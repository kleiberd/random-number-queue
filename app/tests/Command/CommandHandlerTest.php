<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\CommandHandler;
use App\Command\CommandInterface;
use PHPUnit\Framework\TestCase;

class CommandHandlerTest extends TestCase
{
    public function testCommandExists(): void
    {
        $commands = ['command1', 'command2'];

        $handler = $this->getCommandHandler($commands);

        try {
            foreach ($commands as $command) {
                $handler->handleInput(['console', $command]);
            }
        } catch (\InvalidArgumentException $notExpected) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCommandNotExists(): void
    {
        $handler = $this->getCommandHandler([]);

        $handler->handleInput([]);
    }

    private function getCommandHandler(array $commandNames): CommandHandler
    {
        $commands = [];
        foreach ($commandNames as $name) {
            $commands[] = $this->getMockCommand($name);
        }

        return new CommandHandler(...$commands);
    }

    private function getMockCommand(string $commandName): CommandInterface
    {
        $mock = $this->createMock(CommandInterface::class);
        $mock
            ->expects($this->any())
            ->method('getName')
            ->willReturn($commandName);

        return $mock;
    }
}
