<?php

declare(strict_types=1);

namespace App\Queue\ErrorHandler;

use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\MessageInterface;

class DefaultErrorHandler implements ErrorHandlerInterface
{
    public function handle(QueueManagerInterface $manager, MessageInterface $message): void
    {
        $message->incrementFailCount();

        $manager->send($message);
    }
}
