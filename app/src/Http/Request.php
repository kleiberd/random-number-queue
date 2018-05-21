<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    private $query;
    private $request;
    private $attributes;
    private $cookie;
    private $files;
    private $server;

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookie = [],
        array $files = [],
        array $server = []
    ) {
        $this->query = $query;
        $this->request = $request;
        $this->attributes = $attributes;
        $this->cookie = $cookie;
        $this->files = $files;
        $this->server = $server;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        $url = parse_url($this->server['REQUEST_URI']);

        return $url['path'];
    }

    public function getQueryParams(): array
    {
        return $this->query;
    }
}
