<?php

declare(strict_types=1);

namespace App\Framework\Routing;

use App\Framework\Routing\Exception\RouteNotFoundException;
use App\Framework\Routing\RouteCollection\RouteCollectionBuilderInterface;
use App\Framework\Routing\RouteCollection\RouteCollectionItem;
use App\Http\Request;

class Router
{
    private $collection;

    public function __construct(RouteCollectionBuilderInterface $builder)
    {
        $this->collection = $builder->build();
    }

    public function match(Request $request): RouteCollectionItem
    {
        if (isset($this->collection[$request->getUri()])) {
            return $this->collection[$request->getUri()];
        }

        throw new RouteNotFoundException(sprintf('Route not found with this URI: %s', $request->getUri()));
    }
}
