<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Http\Response;
use App\Logger\LogContextFactory;
use App\Queue\Manager\QueueManagerInterface;
use App\Queue\Message\NumberMessage;
use Psr\Log\LoggerInterface;

class GenerateNumberController
{
    private $queueManager;
    private $logger;

    public function __construct(QueueManagerInterface $queueManager, LoggerInterface $logger)
    {
        $this->queueManager = $queueManager;
        $this->logger = $logger;
    }

    public function generate(): Response
    {
        $randomNumber = random_int(0, 99999999);

        /** @var NumberMessage $message */
        $message = $this->queueManager->createNewMessage();
        $message->setNumber($randomNumber);

        $this->queueManager->send($message);

        $this->logger->debug(
            sprintf('Random number has been created (%d)', $randomNumber),
            LogContextFactory::create($message)
        );

        return new JsonResponse([
            'number' => $randomNumber,
        ]);
    }
}
