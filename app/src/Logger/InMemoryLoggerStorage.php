<?php

declare(strict_types=1);

namespace App\Logger;

use App\Model\Log;

class InMemoryLoggerStorage implements LoggerStorageInterface
{
    private $logs = [];

    public function store(string $logLevel, string $message, array $context = []): void
    {
        if (isset($context['correlation_id'])) {
            $this->logs[$context['correlation_id']][] = ['log_level' => $logLevel, 'message' => $message];
        }
    }

    public function findAllByCorrelationId(int $correlationId): array
    {
        $logs = [];
        foreach ($this->logs[$correlationId] as $item) {
            $logs[] = Log::create($correlationId, $item['log_level'], $item['message']);
        }

        return $logs;
    }
}
