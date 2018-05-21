<?php

declare(strict_types=1);

namespace App\Framework\Controller;

use App\DependencyInjection\ContainerInterface;
use App\Framework\Routing\Router;
use App\Http\Request;

class ControllerResolver
{
    private $container;
    private $router;

    public function __construct(ContainerInterface $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    public function resolve(Request $request): callable
    {
        $route = $this->router->match($request);

        return [$this->container->get($route->getControllerName()), $route->getActionName()];
    }
}
