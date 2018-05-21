<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Http\Request;
use App\Http\RequestMethod;

class RequestFactory
{
    public static function createFromGlobals(): Request
    {
        return new Request($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
    }

    public static function create(string $uri, string $method = RequestMethod::GET, array $query = []): Request
    {
        $server = [
            'REQUEST_URI' => $uri,
            'REQUEST_METHOD' => $method,
        ];

        return new Request($query, [], [], [], [], $server);
    }
}
