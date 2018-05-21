<?php

declare(strict_types=1);

namespace App\Tests\DependencyInjection\Fixtures;

class TestServiceB
{
    private $service;

    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    public function getService(): TestService
    {
        return $this->service;
    }
}
