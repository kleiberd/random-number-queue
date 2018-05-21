<?php

declare(strict_types=1);

namespace App\Queue\ErrorHandler;

use App\Logger\LogContextFactory;
use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\MailMessage;
use App\Queue\Message\MessageInterface;
use App\Queue\Message\NumberMessage;
use Psr\Log\LoggerInterface;

class MailErrorHandler implements ErrorHandlerInterface
{
    private $logger;
    private $queueManager;

    public function __construct(LoggerInterface $logger, QueueManagerInterface $queueManager)
    {
        $this->logger = $logger;
        $this->queueManager = $queueManager;
    }

    public function handle(QueueManagerInterface $manager, MessageInterface $message): void
    {
        $message->incrementFailCount();

        $this->logger->critical(
            sprintf('Message processing failed 3 times (%s:%s)', \get_class($message), $message->getCorrelationId()),
            LogContextFactory::create($message)
        );

        /** @var MailMessage $mailMessage */
        /** @var NumberMessage $message */
        $mailMessage = $this->queueManager->createNewMessage();
        $mailMessage->setNumberMessage($message);
        $mailMessage->setEmail('info@example.com');

        $this->queueManager->send($mailMessage);
    }
}
