<?php

declare(strict_types=1);

namespace App\Command;

interface CommandInterface
{
    /**
     * It returns with command's name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Run command's business logic.
     *
     * @param array $arguments
     */
    public function execute(array $arguments): void;
}
