<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\DependencyInjection\Exception\NotFoundServiceException;

class Container implements ContainerInterface
{
    private $definitions;
    private $services;

    public function set($id, $definition): void
    {
        if (!$this->has($id)) {
            $this->definitions[$id] = $definition;
        }
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundServiceException(sprintf('Service not found with id: %s', $id));
        }

        if (!isset($this->services[$id])) {
            $this->services[$id] = $this->definitions[$id]($this);
        }

        return $this->services[$id];
    }

    public function has($id): bool
    {
        return isset($this->definitions[$id]);
    }
}
