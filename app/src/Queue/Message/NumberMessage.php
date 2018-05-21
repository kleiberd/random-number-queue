<?php

declare(strict_types=1);

namespace App\Queue\Message;

class NumberMessage extends AbstractMessage
{
    /**
     * @var int
     */
    protected $number;

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getCorrelationId(): int
    {
        return $this->number;
    }
}
