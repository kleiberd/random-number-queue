<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Log;

class LogRepository
{
    private $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Log $log): bool
    {
        $stmt = $this->connection->prepare('
            INSERT INTO log
                (correlation_id, log_level, message) 
            VALUES 
                (:correlation_id, :log_level, :message)
        ');

        $stmt->bindParam(':correlation_id', $log->correlationId);
        $stmt->bindParam(':log_level', $log->logLevel);
        $stmt->bindParam(':message', $log->message);

        return $stmt->execute();
    }

    /**
     * @return Log[]
     */
    public function findAllByCorrelationId(int $correlationId): array
    {
        $logs = [];
        $stmt = $this->connection->prepare('
            SELECT log.* 
            FROM log 
            WHERE correlation_id = :correlation_id
        ');
        $stmt->bindParam(':correlation_id', $correlationId);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $item) {
            $logs[] = new Log((int) $item['id'], (int) $item['correlation_id'], $item['log_level'], $item['message']);
        }

        return $logs;
    }
}
