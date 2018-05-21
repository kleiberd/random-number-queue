<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Command\CommandHandler;
use App\Command\WorkerCommand;
use App\Controller\GenerateNumberController;
use App\Controller\HomeController;
use App\Controller\LogController;
use App\Framework\Controller\ControllerResolver;
use App\Framework\Routing\RouteCollection\RouteCollectionBuilder;
use App\Framework\Routing\Router;
use App\Framework\Templating\DefaultTemplateFileGuesser;
use App\Framework\Templating\PhpRenderer;
use App\Framework\Templating\ResponseRenderer;
use App\Logger\DatabaseLoggerStorage;
use App\Logger\Logger;
use App\Queue\Driver\RabbitMqDriver;
use App\Queue\ErrorHandler\DefaultErrorHandler;
use App\Queue\ErrorHandler\DelegateErrorHandler;
use App\Queue\ErrorHandler\MailErrorHandler;
use App\Queue\Manager\QueueManager;
use App\Queue\Message\MailMessage;
use App\Queue\Message\NumberMessage;
use App\Queue\Processor\MailProcessor;
use App\Queue\Processor\NumberProcessor;
use App\Queue\Serializer\MessageSerializer;
use App\Queue\Util\QueueConst;
use App\Queue\Worker\Worker;
use App\Repository\LogRepository;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ContainerBuilder
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function build(array $parameters): ContainerInterface
    {
        $this->buildParameters($parameters);
        $this->buildServices();
        $this->buildQueueServices();

        return $this->container;
    }

    private function buildParameters(array $parameters): void
    {
        foreach ($parameters as $key => $parameter) {
            $this->container->set($key, function () use ($parameter) {
                return $parameter;
            });
        }
    }

    private function buildServices(): void
    {
        $this->container->set(ControllerResolver::class, function (ContainerInterface $container) {
            return new ControllerResolver($container, $container->get(Router::class));
        });

        $this->container->set(Router::class, function () {
            return new Router(new RouteCollectionBuilder());
        });

        $this->container->set(HomeController::class, function (ContainerInterface $container) {
            return new HomeController(
                $container->get(ResponseRenderer::class)
            );
        });

        $this->container->set(GenerateNumberController::class, function (ContainerInterface $container) {
            return new GenerateNumberController(
                $container->get(QueueConst::QUEUE_MANAGER_NUMBER),
                $container->get(Logger::class)
            );
        });

        $this->container->set(LogController::class, function (ContainerInterface $container) {
            return new LogController(
                $container->get(ResponseRenderer::class),
                $container->get(LogRepository::class)
            );
        });

        $this->container->set(ResponseRenderer::class, function (ContainerInterface $container) {
            return new ResponseRenderer(
                $container->get(PhpRenderer::class)
            );
        });

        $this->container->set(PhpRenderer::class, function (ContainerInterface $container) {
            return new PhpRenderer(
                $container->get(DefaultTemplateFileGuesser::class)
            );
        });

        $this->container->set(DefaultTemplateFileGuesser::class, function (ContainerInterface $container) {
            return new DefaultTemplateFileGuesser(
                $container->get('sourceDir').DIRECTORY_SEPARATOR.'Resources'.DIRECTORY_SEPARATOR.'Views'
            );
        });

        $this->container->set(MessageSerializer::class, function () {
            return new MessageSerializer();
        });

        $this->container->set(CommandHandler::class, function (ContainerInterface $container) {
            return new CommandHandler(
                $container->get(WorkerCommand::class)
            );
        });

        $this->container->set(\PDO::class, function () {
            $pdo = new \PDO('mysql:host=127.0.0.1;dbname=rnq-db', 'rnq-db', 'rnq-db');
            $pdo->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );

            return $pdo;
        });

        $this->container->set(LogRepository::class, function (ContainerInterface $container) {
            return new LogRepository(
                $container->get(\PDO::class)
            );
        });

        $this->container->set(DatabaseLoggerStorage::class, function (ContainerInterface $container) {
            return new DatabaseLoggerStorage(
                $container->get(LogRepository::class)
            );
        });

        $this->container->set(Logger::class, function (ContainerInterface $container) {
            return new Logger(
                $container->get(DatabaseLoggerStorage::class)
            );
        });
    }

    private function buildQueueServices(): void
    {
        $this->container->set(AMQPStreamConnection::class, function () {
            return new AMQPStreamConnection(
                'localhost',
                '5672',
                'guest',
                'guest'
            );
        });

        $this->container->set(AMQPChannel::class, function (ContainerInterface $container) {
            return new AMQPChannel($container->get(AMQPStreamConnection::class));
        });

        $this->container->set(QueueConst::QUEUE_MANAGER_NUMBER, function (ContainerInterface $container) {
            return new QueueManager(
                $container->get(QueueConst::QUEUE_DRIVER_NUMBER),
                NumberMessage::class,
                $container->get(DelegateErrorHandler::class)
            );
        });

        $this->container->set(QueueConst::QUEUE_DRIVER_NUMBER, function (ContainerInterface $container) {
            return new RabbitMqDriver(
                $container->get(AMQPChannel::class),
                QueueConst::QUEUE_NAME_NUMBER,
                $container->get(MessageSerializer::class)
            );
        });

        $this->container->set(NumberProcessor::class, function () {
            return new NumberProcessor();
        });

        $this->container->set(QueueConst::QUEUE_WORKER_NUMBER, function (ContainerInterface $container) {
            return new Worker(
                $container->get(QueueConst::QUEUE_MANAGER_NUMBER),
                $container->get(NumberProcessor::class),
                $container->get(Logger::class)
            );
        });

        $this->container->set(WorkerCommand::class, function (ContainerInterface $container) {
            return new WorkerCommand(
                $container
            );
        });

        $this->container->set(MailErrorHandler::class, function (ContainerInterface $container) {
            return new MailErrorHandler(
                $container->get(Logger::class),
                $container->get(QueueConst::QUEUE_MANAGER_MAIL)
            );
        });

        $this->container->set(DefaultErrorHandler::class, function () {
            return new DefaultErrorHandler();
        });

        $this->container->set(DelegateErrorHandler::class, function (ContainerInterface $container) {
            return new DelegateErrorHandler(
                $container->get(DefaultErrorHandler::class),
                $container->get(MailErrorHandler::class)
            );
        });

        $this->container->set(QueueConst::QUEUE_DRIVER_MAIL, function (ContainerInterface $container) {
            return new RabbitMqDriver(
                $container->get(AMQPChannel::class),
                QueueConst::QUEUE_NAME_MAIL,
                $container->get(MessageSerializer::class)
            );
        });

        $this->container->set(QueueConst::QUEUE_MANAGER_MAIL, function (ContainerInterface $container) {
            return new QueueManager(
                $container->get(QueueConst::QUEUE_DRIVER_MAIL),
                MailMessage::class,
                $container->get(DefaultErrorHandler::class)
            );
        });

        $this->container->set(QueueConst::QUEUE_WORKER_MAIL, function (ContainerInterface $container) {
            return new Worker(
                $container->get(QueueConst::QUEUE_MANAGER_MAIL),
                $container->get(MailProcessor::class),
                $container->get(Logger::class)
            );
        });

        $this->container->set(MailProcessor::class, function (ContainerInterface $container) {
            return new MailProcessor(
                $container->get(Logger::class)
            );
        });
    }
}
