<?php

declare(strict_types=1);

namespace App\Model;

class Log
{
    public $id;
    public $correlationId;
    public $logLevel;
    public $message;

    public function __construct(?int $id, int $correlationId, string $logLevel, string $message)
    {
        $this->id = $id;
        $this->correlationId = $correlationId;
        $this->logLevel = $logLevel;
        $this->message = $message;
    }

    public static function create(int $correlationId, string $logLevel, string $message): self
    {
        return new self(null, $correlationId, $logLevel, $message);
    }
}
