<?php

declare(strict_types=1);

namespace App\Queue\Driver;

use App\Queue\Message\MessageInterface;

class SplQueueDriver implements DriverInterface
{
    private $messages;
    private $messageCount = 0;
    private $maxMessagesCount;

    public function __construct(int $maxMessagesCount)
    {
        $this->messages = new \SplQueue();
        $this->maxMessagesCount = $maxMessagesCount;
    }

    public function send(MessageInterface $message): void
    {
        $this->messages->enqueue($message);

        ++$this->messageCount;
    }

    public function receive(\Closure $closure): void
    {
        do {
            if (!$this->messages->isEmpty()) {
                $closure($this->messages->dequeue());
            }
        } while ($this->messageCount < $this->maxMessagesCount);
    }
}
