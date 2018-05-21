<?php

declare(strict_types=1);

namespace App\Queue\Processor;

use App\Logger\LogContextFactory;
use App\Queue\Message\MailMessage;
use App\Queue\Message\MessageInterface;
use Psr\Log\LoggerInterface;

class MailProcessor extends AbstractProcessor
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    protected function doProcess(MessageInterface $message): void
    {
        /* @var MailMessage $message */
        $this->logger->critical(
            sprintf('Sent email to %s. Message: %s', $message->getEmail(), serialize($message->getNumberMessage())),
            LogContextFactory::create($message)
        );
    }

    protected function isSupported(MessageInterface $message): bool
    {
        return $message instanceof MailMessage;
    }
}
