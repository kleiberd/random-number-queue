<?php

declare(strict_types=1);

namespace App\Tests\Logger;

use App\Logger\InMemoryLoggerStorage;
use App\Logger\Logger;
use App\Logger\LoggerStorageInterface;
use App\Model\Log;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerTest extends TestCase
{
    public function testLogger(): void
    {
        $storage = new InMemoryLoggerStorage();

        $logger = $this->getLogger($storage);

        $logger->info('Test log', ['correlation_id' => 123]);

        $logs = $storage->findAllByCorrelationId(123);

        $this->assertCount(1, $logs);

        $firstLog = reset($logs);
        $this->assertInstanceOf(Log::class, $firstLog);
        $this->assertEquals('Test log', $firstLog->message);
    }

    private function getLogger(LoggerStorageInterface $storage): LoggerInterface
    {
        return new Logger($storage);
    }
}
