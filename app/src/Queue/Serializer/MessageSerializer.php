<?php

declare(strict_types=1);

namespace App\Queue\Serializer;

use App\Queue\Message\MessageInterface;

class MessageSerializer implements SerializerInterface
{
    public function serialize(MessageInterface $message): string
    {
        return serialize($message);
    }

    public function unserialize(string $string): MessageInterface
    {
        return unserialize($string, ['allowed_classes' => true]);
    }
}
