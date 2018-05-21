<?php

declare(strict_types=1);

namespace App\Queue\Processor;

use App\Queue\Message\MessageInterface;

interface ProcessorInterface
{
    /**
     * Process message from queue.
     *
     * @param MessageInterface $message
     */
    public function process(MessageInterface $message): void;
}
