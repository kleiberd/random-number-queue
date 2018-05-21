<?php

declare(strict_types=1);

namespace App\Framework\Routing\RouteCollection;

class RouteCollectionItem
{
    private $controllerName;
    private $actionName;

    public function __construct(string $controllerName, string $actionName)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function setControllerName(string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function setActionName(string $actionName): void
    {
        $this->actionName = $actionName;
    }
}
