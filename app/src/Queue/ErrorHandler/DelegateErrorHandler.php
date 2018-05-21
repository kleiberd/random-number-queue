<?php

declare(strict_types=1);

namespace App\Queue\ErrorHandler;

use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\MessageInterface;

class DelegateErrorHandler implements ErrorHandlerInterface
{
    private $defaultErrorHandler;
    private $mailErrorHandler;

    public function __construct(DefaultErrorHandler $defaultErrorHandler, MailErrorHandler $mailErrorHandler)
    {
        $this->defaultErrorHandler = $defaultErrorHandler;
        $this->mailErrorHandler = $mailErrorHandler;
    }

    public function handle(QueueManagerInterface $manager, MessageInterface $message): void
    {
        if ($message->getFailCount() < 2) {
            $this->defaultErrorHandler->handle($manager, $message);
        } else {
            $this->mailErrorHandler->handle($manager, $message);
        }
    }
}
