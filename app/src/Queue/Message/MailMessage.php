<?php

declare(strict_types=1);

namespace App\Queue\Message;

class MailMessage extends AbstractMessage
{
    /**
     * @var NumberMessage
     */
    private $numberMessage;

    /**
     * @var string
     */
    private $email;

    public function setNumberMessage(NumberMessage $numberMessage): void
    {
        $this->numberMessage = $numberMessage;
    }

    public function getNumberMessage(): NumberMessage
    {
        return $this->numberMessage;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCorrelationId(): int
    {
        return $this->numberMessage->getCorrelationId();
    }
}
