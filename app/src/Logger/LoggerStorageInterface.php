<?php

declare(strict_types=1);

namespace App\Logger;

use App\Model\Log;

interface LoggerStorageInterface
{
    /**
     * Persists log item.
     *
     * @param string $logLevel
     * @param string $message
     * @param array  $context
     *
     * @return mixed
     */
    public function store(string $logLevel, string $message, array $context = []): void;

    /**
     * Find all log items by correlation id.
     *
     * @param int $correlationId
     *
     * @return Log[]
     */
    public function findAllByCorrelationId(int $correlationId): array;
}
