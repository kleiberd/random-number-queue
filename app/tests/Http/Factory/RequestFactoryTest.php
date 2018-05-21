<?php

declare(strict_types=1);

namespace App\Tests\Http\Factory;

use App\Http\Factory\RequestFactory;
use App\Http\Request;
use App\Http\RequestMethod;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    public function testCreateFromGlobals(): void
    {
        $request = RequestFactory::createFromGlobals();

        $this->assertInstanceOf(Request::class, $request);
    }

    public function testCreate(): void
    {
        $uri = '/test';
        $method = RequestMethod::POST;
        $query = ['param' => 1];

        $request = RequestFactory::create($uri, $method, $query);

        $this->assertEquals($uri, $request->getUri());
        $this->assertEquals(RequestMethod::POST, $request->getMethod());
        $this->assertEquals($query, $request->getQueryParams());
    }
}
