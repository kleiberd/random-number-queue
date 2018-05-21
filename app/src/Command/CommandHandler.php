<?php

declare(strict_types=1);

namespace App\Command;

class CommandHandler
{
    private $commands;

    public function __construct(CommandInterface ...$commands)
    {
        $this->commands = $commands;
    }

    public function handleInput(array $input): void
    {
        if (!empty($input[1])) {
            $command = $this->getCommand($input[1]);
            $input = \array_slice($input, 2);

            $command->execute($input);

            return;
        }

        throw new \InvalidArgumentException('You must specify at least one argument!');
    }

    private function getCommand(string $name): CommandInterface
    {
        foreach ($this->commands as $command) {
            if ($name === $command->getName()) {
                return $command;
            }
        }

        throw new \InvalidArgumentException(sprintf('Command does not exist with name: "%s"', $name));
    }
}
