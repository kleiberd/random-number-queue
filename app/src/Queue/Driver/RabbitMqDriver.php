<?php

declare(strict_types=1);

namespace App\Queue\Driver;

use App\Queue\Message\MessageInterface;
use App\Queue\Serializer\SerializerInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqDriver implements DriverInterface
{
    private $channel;
    private $queueName;
    private $serializer;

    public function __construct(AMQPChannel $channel, string $queueName, SerializerInterface $serializer)
    {
        $this->channel = $channel;
        $this->queueName = $queueName;
        $this->serializer = $serializer;

        $this->channel->queue_declare($this->queueName, false, false, false, false);
    }

    public function send(MessageInterface $message): void
    {
        $rabbitMessage = new AMQPMessage($this->serializer->serialize($message));

        $this->channel->basic_publish($rabbitMessage, '', $this->queueName);
    }

    public function receive(\Closure $closure): void
    {
        $callback = function ($msg) use ($closure): void {
            /* @var AMQPMessage $msg */
            $closure($this->serializer->unserialize($msg->body));

            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $this->channel->basic_consume($this->queueName, '', false, false, false, false, $callback);

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
    }
}
