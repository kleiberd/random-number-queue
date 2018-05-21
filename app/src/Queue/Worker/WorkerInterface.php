<?php

declare(strict_types=1);

namespace App\Queue\Worker;

interface WorkerInterface
{
    /**
     * The main queue process.
     */
    public function work(): void;
}
