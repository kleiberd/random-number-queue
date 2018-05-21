<?php

declare(strict_types=1);

namespace App\Tests\DependencyInjection\Fixtures;

class TestServiceC
{
    private $service;
    private $serviceB;

    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    public function getService(): TestService
    {
        return $this->service;
    }

    public function getServiceB(): TestServiceB
    {
        return $this->serviceB;
    }

    public function setServiceB($serviceB): void
    {
        $this->serviceB = $serviceB;
    }
}
