<?php

declare(strict_types=1);

namespace App\Queue\Serializer;

use App\Queue\Message\MessageInterface;

interface SerializerInterface
{
    /**
     * Message serialization.
     *
     * @param MessageInterface $message
     *
     * @return string
     */
    public function serialize(MessageInterface $message): string;

    /**
     * Opposite Message serialization method.
     *
     * @param string $string
     *
     * @return MessageInterface
     */
    public function unserialize(string $string): MessageInterface;
}
