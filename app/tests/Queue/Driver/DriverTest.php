<?php

declare(strict_types=1);

namespace App\Tests\Queue\Driver;

use App\Queue\Driver\DriverInterface;
use App\Queue\Driver\SplQueueDriver;
use App\Queue\Message\MessageInterface;
use PHPUnit\Framework\TestCase;

class DriverTest extends TestCase
{
    public function testDriver(): void
    {
        $driver = $this->getDriver();

        $driver->send($this->getMockMessage());

        $driver->receive(function (MessageInterface $message): void {
            $this->assertInstanceOf(MessageInterface::class, $message);
        });
    }

    private function getDriver(): DriverInterface
    {
        return new SplQueueDriver(1);
    }

    private function getMockMessage(): MessageInterface
    {
        return $this->createMock(MessageInterface::class);
    }
}
