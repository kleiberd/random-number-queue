<?php

declare(strict_types=1);

namespace App\Framework\Routing\RouteCollection;

interface RouteCollectionBuilderInterface
{
    /**
     * Builds RouteCollection for Router.
     *
     * @return RouteCollection
     */
    public function build(): RouteCollection;
}
