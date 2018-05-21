<?php

declare(strict_types=1);

namespace App\Controller;

use App\Framework\Templating\ResponseRendererInterface;
use App\Http\Request;
use App\Http\Response;
use App\Repository\LogRepository;

class LogController
{
    private $renderer;
    private $logRepository;

    public function __construct(ResponseRendererInterface $renderer, LogRepository $logRepository)
    {
        $this->renderer = $renderer;
        $this->logRepository = $logRepository;
    }

    public function getLogsByCorrelationId(Request $request): Response
    {
        $correlationId = $request->getQueryParams()['number'];
        $logs = $this->logRepository->findAllByCorrelationId((int) $correlationId);

        return $this->renderer->render('log.logs', [
            'logs' => $logs,
        ]);
    }
}
