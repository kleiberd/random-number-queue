<?php

declare(strict_types=1);

namespace App\Tests\Queue\Fixtures;

use App\Queue\Message\AbstractMessage;

class TestMessage extends AbstractMessage
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getCorrelationId(): int
    {
        return $this->id;
    }
}
