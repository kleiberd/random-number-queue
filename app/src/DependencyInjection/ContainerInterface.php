<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    /**
     * Sets a service definition.
     *
     * @param string $id
     * @param object $definition
     */
    public function set($id, $definition);
}
