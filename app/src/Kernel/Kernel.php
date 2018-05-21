<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Command\CommandHandler;
use App\DependencyInjection\Container;
use App\DependencyInjection\ContainerBuilder;
use App\DependencyInjection\ContainerInterface;
use App\Framework\Controller\ControllerResolver;
use App\Http\Request;
use App\Http\Response;

class Kernel
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var bool
     */
    private $isBooted;

    /**
     * @var string
     */
    private $projectDir;

    public function boot(): void
    {
        if (!$this->isBooted) {
            $this->isBooted = true;
            $this->projectDir = $this->getProjectDir();

            $this->initializeContainer();
        }
    }

    public function handleRequest(Request $request): Response
    {
        $this->boot();

        $controllerResolver = $this->container->get(ControllerResolver::class);

        $controller = $controllerResolver->resolve($request);

        return call_user_func_array($controller, [$request]);
    }

    public function handleInput(array $argv): void
    {
        $this->boot();

        $commandHandler = $this->container->get(CommandHandler::class);
        $commandHandler->handleInput($argv);
    }

    private function initializeContainer(): void
    {
        $containerBuilder = new ContainerBuilder(new Container());

        $this->container = $containerBuilder->build($this->getContainerParameters());
    }

    private function getProjectDir(): string
    {
        if (null === $this->projectDir) {
            $r = new \ReflectionObject($this);
            $dir = $rootDir = dirname($r->getFileName());
            while (!file_exists($dir.'/composer.json')) {
                if ($dir === dirname($dir)) {
                    return $this->projectDir = $rootDir;
                }
                $dir = dirname($dir);
            }
            $this->projectDir = $dir;
        }

        return $this->projectDir;
    }

    private function getContainerParameters(): array
    {
        return [
            'projectDir' => $this->projectDir,
            'sourceDir' => $this->projectDir.DIRECTORY_SEPARATOR.'src',
        ];
    }
}
