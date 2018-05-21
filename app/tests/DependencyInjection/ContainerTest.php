<?php

declare(strict_types=1);

namespace App\Tests\DependencyInjection;

use App\DependencyInjection\Container;
use App\DependencyInjection\ContainerInterface;
use App\Tests\DependencyInjection\Fixtures\TestService;
use App\Tests\DependencyInjection\Fixtures\TestServiceB;
use App\Tests\DependencyInjection\Fixtures\TestServiceC;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @dataProvider getContainerParametersDataProvider
     *
     * @param mixed $value
     */
    public function testContainerRegisterParameters(string $key, $value): void
    {
        $container = new Container();
        $container->set($key, function () use ($value) {
            return $value;
        });

        $this->assertEquals($value, $container->get($key));
    }

    public function testContainerRegisterServices(): void
    {
        $container = new Container();
        $container->set(TestServiceC::class, function (ContainerInterface $container) {
            $serviceC = new TestServiceC(
                $container->get(TestService::class)
            );
            $serviceC->setServiceB($container->get(TestServiceB::class));

            return $serviceC;
        });

        $container->set(TestService::class, function () {
            return new TestService();
        });

        $container->set(TestServiceB::class, function (ContainerInterface $container) {
            return new TestServiceB(
                $container->get(TestService::class)
            );
        });

        $this->assertInstanceOf(TestService::class, $container->get(TestService::class));

        $this->assertInstanceOf(TestServiceB::class, $container->get(TestServiceB::class));
        $this->assertInstanceOf(TestService::class, $container->get(TestServiceB::class)->getService());

        $this->assertInstanceOf(TestServiceC::class, $container->get(TestServiceC::class));
        $this->assertInstanceOf(TestServiceB::class, $container->get(TestServiceC::class)->getServiceB());
        $this->assertInstanceOf(TestService::class, $container->get(TestServiceC::class)->getService());
    }

    /**
     * @expectedException \App\DependencyInjection\Exception\NotFoundServiceException
     */
    public function testContainerThrowNotFoundServiceException(): void
    {
        $container = new Container();

        $container->get(TestService::class);
    }

    public function getContainerParametersDataProvider(): array
    {
        return [
            ['projectDir', '/tmp/project'],
            ['debug', true],
        ];
    }
}
