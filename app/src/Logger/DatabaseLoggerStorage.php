<?php

declare(strict_types=1);

namespace App\Logger;

use App\Model\Log;
use App\Repository\LogRepository;

class DatabaseLoggerStorage implements LoggerStorageInterface
{
    private $repository;

    public function __construct(LogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(string $logLevel, string $message, array $context = []): void
    {
        if (isset($context['correlation_id'])) {
            $this->repository->save(Log::create($context['correlation_id'], $logLevel, $message));
        }
    }

    public function findAllByCorrelationId(int $correlationId): array
    {
        return $this->repository->findAllByCorrelationId($correlationId);
    }
}
