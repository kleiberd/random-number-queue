<?php

declare(strict_types=1);

namespace App\Queue\ErrorHandler;

use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\MessageInterface;

interface ErrorHandlerInterface
{
    /**
     * @param QueueManagerInterface $queueManager
     * @param MessageInterface      $message
     */
    public function handle(QueueManagerInterface $queueManager, MessageInterface $message): void;
}
