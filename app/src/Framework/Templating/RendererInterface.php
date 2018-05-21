<?php

declare(strict_types=1);

namespace App\Framework\Templating;

interface RendererInterface
{
    /**
     * It evaluates the template and returns with it.
     *
     * @param string $view
     * @param array  $parameters
     *
     * @return string
     */
    public function render(string $view, array $parameters = []): string;
}
