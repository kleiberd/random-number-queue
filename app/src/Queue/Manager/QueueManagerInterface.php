<?php

declare(strict_types=1);

namespace App\Queue\Manager;

use App\Queue\Message\AbstractMessage;
use App\Queue\Message\MessageInterface;

interface QueueManagerInterface
{
    /**
     * Creates a new Message for Queue.
     *
     * @return AbstractMessage
     */
    public function createNewMessage(): AbstractMessage;

    /**
     * Send message to Queue.
     *
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message): void;

    /**
     * Receive messages from Queue.
     */
    public function receive(\Closure $closure): void;

    /**
     * Queue message process failed.
     *
     * @param MessageInterface $message
     */
    public function failed(MessageInterface $message): void;
}
