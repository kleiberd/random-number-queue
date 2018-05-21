<?php

declare(strict_types=1);

namespace App\Framework\Routing\RouteCollection;

use App\Controller\GenerateNumberController;
use App\Controller\HomeController;
use App\Controller\LogController;

class RouteCollectionBuilder implements RouteCollectionBuilderInterface
{
    public function build(): RouteCollection
    {
        $routeCollection = new RouteCollection();

        $routeCollection['/'] = new RouteCollectionItem(HomeController::class, 'index');
        $routeCollection['/generate'] = new RouteCollectionItem(GenerateNumberController::class, 'generate');
        $routeCollection['/log'] = new RouteCollectionItem(LogController::class, 'getLogsByCorrelationId');

        return $routeCollection;
    }
}
