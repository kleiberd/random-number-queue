<?php

declare(strict_types=1);

namespace App\Queue\Worker;

use App\Logger\LogContextFactory;
use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\MessageInterface;
use App\Queue\Processor\ProcessorInterface;
use Psr\Log\LoggerInterface;

class Worker implements WorkerInterface
{
    private $queueManager;
    private $processor;
    private $logger;

    public function __construct(QueueManagerInterface $queueManager, ProcessorInterface $processor, LoggerInterface $logger)
    {
        $this->queueManager = $queueManager;
        $this->processor = $processor;
        $this->logger = $logger;
    }

    public function work(): void
    {
        $this->queueManager->receive($this->doWork());
    }

    private function doWork(): \Closure
    {
        return function (MessageInterface $message): void {
            try {
                $this->logStart($message);

                $this->processor->process($message);

                $this->logSuccess($message);
            } catch (\Exception $e) {
                $this->queueManager->failed($message);

                $this->logFailed($message, $e);
            }
        };
    }

    private function logStart(MessageInterface $message): void
    {
        $this->logger->debug(
            sprintf('Start processing message (%s:%s)', \get_class($message), $message->getCorrelationId()),
            LogContextFactory::create($message)
        );
    }

    private function logSuccess(MessageInterface $message): void
    {
        $this->logger->debug(
            sprintf('Message processing was successful (%s:%s)', \get_class($message), $message->getCorrelationId()),
            LogContextFactory::create($message)
        );
    }

    private function logFailed(MessageInterface $message, \Exception $e): void
    {
        $this->logger->error(
            sprintf('Message processing has been failed (%s:%s). Fail count: %d Exception: %s',
                \get_class($message), $message->getCorrelationId(), $message->getFailCount(), $e->getMessage()
            ),
            LogContextFactory::create($message)
        );
    }
}
