<?php

declare(strict_types=1);

namespace App\Tests\Queue\ErrorHandler;

use App\Queue\Driver\SplQueueDriver;
use App\Queue\ErrorHandler\DefaultErrorHandler;
use App\Queue\ErrorHandler\ErrorHandlerInterface;
use App\Queue\Manager\QueueManager;
use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\MessageInterface;
use App\Tests\Queue\Fixtures\TestMessage;
use PHPUnit\Framework\TestCase;

class DefaultErrorHandlerTest extends TestCase
{
    public function testHandle(): void
    {
        $message = new TestMessage(1);

        $handler = $this->getErrorHandler();
        $queueManager = $this->getQueueManager();

        $handler->handle($queueManager, $message);

        $queueManager->receive(function (MessageInterface $message): void {
            $this->assertEquals(1, $message->getFailCount());
        });
    }

    private function getErrorHandler(): ErrorHandlerInterface
    {
        return new DefaultErrorHandler();
    }

    private function getQueueManager(): QueueManagerInterface
    {
        return new QueueManager(
            new SplQueueDriver(1),
            TestMessage::class,
            $this->getErrorHandler()
        );
    }
}
