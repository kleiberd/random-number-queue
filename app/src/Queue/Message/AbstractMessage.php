<?php

declare(strict_types=1);

namespace App\Queue\Message;

abstract class AbstractMessage implements MessageInterface
{
    private $failCount = 0;

    abstract public function getCorrelationId(): int;

    public function getFailCount(): int
    {
        return $this->failCount;
    }

    public function incrementFailCount(): void
    {
        ++$this->failCount;
    }
}
