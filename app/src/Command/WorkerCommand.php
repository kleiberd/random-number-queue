<?php

declare(strict_types=1);

namespace App\Command;

use App\DependencyInjection\ContainerInterface;
use App\DependencyInjection\Exception\NotFoundServiceException;
use App\Queue\Worker\WorkerInterface;

class WorkerCommand implements CommandInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function execute(array $arguments): void
    {
        if (!empty($arguments[0])) {
            $worker = $this->getWorkerByName($arguments[0]);
            $worker->work();

            return;
        }

        throw new \InvalidArgumentException('You must specify a worker name');
    }

    public function getName(): string
    {
        return 'worker';
    }

    private function getWorkerByName(string $name): WorkerInterface
    {
        try {
            return $this->container->get('queue_worker_'.$name);
        } catch (NotFoundServiceException $e) {
            throw new \InvalidArgumentException(sprintf('Queue worker does not exist with name: "%s"', $name));
        }
    }
}
