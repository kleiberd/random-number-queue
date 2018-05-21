<?php

declare(strict_types=1);

namespace App\Tests\Queue\ErrorHandler;

use App\Queue\ErrorHandler\DefaultErrorHandler;
use App\Queue\ErrorHandler\DelegateErrorHandler;
use App\Queue\ErrorHandler\ErrorHandlerInterface;
use App\Queue\ErrorHandler\MailErrorHandler;
use App\Queue\Manager\QueueManagerInterface;
use App\Tests\Queue\Fixtures\TestMessage;
use PHPUnit\Framework\TestCase;

class DelegateErrorHandlerTest extends TestCase
{
    public function testDefaultHandle(): void
    {
        $message = new TestMessage(1);
        $handler = $this->getMockDelegateErrorHandler();

        $this->expectExceptionMessage(DefaultErrorHandler::class);
        $handler->handle($this->getMockQueueManager(), $message);
    }

    public function testMailHandle(): void
    {
        $message = new TestMessage(1);
        $message->incrementFailCount();
        $message->incrementFailCount();

        $handler = $this->getMockDelegateErrorHandler();

        $this->expectExceptionMessage(MailErrorHandler::class);
        $handler->handle($this->getMockQueueManager(), $message);
    }

    private function getMockDelegateErrorHandler(): ErrorHandlerInterface
    {
        $mockDefault = $this->createMock(DefaultErrorHandler::class);

        $mockDefault
            ->expects($this->any())
            ->method('handle')
            ->willThrowException(new \Exception(DefaultErrorHandler::class));

        $mockMail = $this->createMock(MailErrorHandler::class);

        $mockMail
            ->expects($this->any())
            ->method('handle')
            ->willThrowException(new \Exception(MailErrorHandler::class));

        return new DelegateErrorHandler($mockDefault, $mockMail);
    }

    private function getMockQueueManager(): QueueManagerInterface
    {
        return $this->createMock(QueueManagerInterface::class);
    }
}
