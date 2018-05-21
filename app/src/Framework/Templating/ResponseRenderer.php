<?php

declare(strict_types=1);

namespace App\Framework\Templating;

use App\Http\Response;

class ResponseRenderer implements ResponseRendererInterface
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(string $view, array $parameters = []): Response
    {
        return new Response($this->renderer->render($view, $parameters));
    }
}
