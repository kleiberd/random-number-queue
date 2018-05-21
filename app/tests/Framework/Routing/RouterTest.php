<?php

declare(strict_types=1);

namespace App\Tests\Framework\Routing;

use App\Framework\Routing\RouteCollection\RouteCollection;
use App\Framework\Routing\RouteCollection\RouteCollectionBuilderInterface;
use App\Framework\Routing\RouteCollection\RouteCollectionItem;
use App\Framework\Routing\Router;
use App\Http\Factory\RequestFactory;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @dataProvider getRouteCollectionDataProvider
     */
    public function testRouteItemExists(string $path, RouteCollectionItem $item): void
    {
        $request = RequestFactory::create($path);

        $router = new Router($this->getMockRouteCollectionBuilder([$path => $item]));

        $this->assertInstanceOf(RouteCollectionItem::class, $router->match($request));
        $this->assertEquals($item, $router->match($request));
    }

    /**
     * @expectedException \App\Framework\Routing\Exception\RouteNotFoundException
     */
    public function testRouteItemNotExists(): void
    {
        $router = new Router($this->getMockRouteCollectionBuilder([]));

        $router->match(RequestFactory::create('/notfound'));
    }

    public function getRouteCollectionDataProvider(): array
    {
        return [
            ['/', new RouteCollectionItem('TestController', 'test')],
            ['/test', new RouteCollectionItem('TestController', 'test3')],
        ];
    }

    private function getMockRouteCollectionBuilder(array $routeItems): RouteCollectionBuilderInterface
    {
        $mock = $this->createMock(RouteCollectionBuilderInterface::class);

        $mock
            ->expects($this->any())
            ->method('build')
            ->willReturn($this->getMockRouteCollection($routeItems));

        return $mock;
    }

    private function getMockRouteCollection(array $items): RouteCollection
    {
        $mock = $this->createMock(RouteCollection::class);

        $mock
            ->expects($this->any())
            ->method('offsetGet')
            ->willReturnCallback(function ($key) use ($items) {
                return $items[$key];
            });

        $mock
            ->expects($this->any())
            ->method('offsetExists')
            ->willReturnCallback(function ($key) use ($items) {
                return isset($items[$key]);
            });

        return $mock;
    }
}
