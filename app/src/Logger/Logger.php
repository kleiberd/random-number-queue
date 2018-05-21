<?php

declare(strict_types=1);

namespace App\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Logger implements LoggerInterface
{
    private $storage;

    public function __construct(LoggerStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function emergency($message, array $context = []): void
    {
        $this->storage->store(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert($message, array $context = []): void
    {
        $this->storage->store(LogLevel::ALERT, $message, $context);
    }

    public function critical($message, array $context = []): void
    {
        $this->storage->store(LogLevel::CRITICAL, $message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->storage->store(LogLevel::ERROR, $message, $context);
    }

    public function warning($message, array $context = []): void
    {
        $this->storage->store(LogLevel::WARNING, $message, $context);
    }

    public function notice($message, array $context = []): void
    {
        $this->storage->store(LogLevel::NOTICE, $message, $context);
    }

    public function info($message, array $context = []): void
    {
        $this->storage->store(LogLevel::INFO, $message, $context);
    }

    public function debug($message, array $context = []): void
    {
        $this->storage->store(LogLevel::DEBUG, $message, $context);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->storage->store($level, $message, $context);
    }
}
