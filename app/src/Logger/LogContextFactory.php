<?php

declare(strict_types=1);

namespace App\Logger;

use App\Queue\Message\MessageInterface;

class LogContextFactory
{
    public static function create(MessageInterface $message): array
    {
        return ['correlation_id' => $message->getCorrelationId()];
    }
}
