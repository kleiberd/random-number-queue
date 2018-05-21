<?php

declare(strict_types=1);

namespace App\Queue\Processor;

use App\Queue\Message\MessageInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    public function process(MessageInterface $message): void
    {
        if ($this->isSupported($message)) {
            $this->doProcess($message);

            return;
        }

        throw new \InvalidArgumentException(
        sprintf('The processor (%s) not supported the message (%s)',
            \get_class($this),
            \get_class($message)
        ));
    }

    abstract protected function doProcess(MessageInterface $message): void;

    abstract protected function isSupported(MessageInterface $message): bool;
}
