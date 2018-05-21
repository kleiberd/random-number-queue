<?php

declare(strict_types=1);

namespace App\Framework\Templating;

use App\Http\Response;

interface ResponseRendererInterface
{
    /**
     * Creates Response object from view template.
     *
     * @param string $view
     * @param array  $parameters
     *
     * @return Response
     */
    public function render(string $view, array $parameters = []): Response;
}
