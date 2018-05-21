<?php

declare(strict_types=1);

namespace App\Queue\Message;

interface MessageInterface
{
    /**
     * Get correlation id.
     *
     * @return int
     */
    public function getCorrelationId(): int;

    /**
     * Get fail counter.
     *
     * @return int
     */
    public function getFailCount(): int;

    /**
     * Increment message's fail counter.
     */
    public function incrementFailCount(): void;
}
