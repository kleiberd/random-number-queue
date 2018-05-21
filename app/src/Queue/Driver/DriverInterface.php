<?php

declare(strict_types=1);

namespace App\Queue\Driver;

use App\Queue\Message\MessageInterface;

interface DriverInterface
{
    /**
     * Push message to Queue service.
     *
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message): void;

    /**
     * Wait and receive message from Queue service.
     *
     * @param \Closure $closure
     */
    public function receive(\Closure $closure): void;
}
