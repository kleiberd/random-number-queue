<?php

declare(strict_types=1);

namespace App\Queue\Manager;

use App\Queue\Driver\DriverInterface;
use App\Queue\ErrorHandler\ErrorHandlerInterface;
use App\Queue\Message\AbstractMessage;
use App\Queue\Message\MessageInterface;

class QueueManager implements QueueManagerInterface
{
    protected $driver;
    protected $messagePrototype;
    protected $errorHandler;

    public function __construct(DriverInterface $driver, string $messagePrototype, ErrorHandlerInterface $errorHandler)
    {
        $this->driver = $driver;
        $this->messagePrototype = $messagePrototype;
        $this->errorHandler = $errorHandler;
    }

    public function createNewMessage(): AbstractMessage
    {
        return new $this->messagePrototype();
    }

    public function send(MessageInterface $message): void
    {
        $this->driver->send($message);
    }

    public function receive(\Closure $closure): void
    {
        $this->driver->receive($closure);
    }

    public function failed(MessageInterface $message): void
    {
        $this->errorHandler->handle($this, $message);
    }
}
