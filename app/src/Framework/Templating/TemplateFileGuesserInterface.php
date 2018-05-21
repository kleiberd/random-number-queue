<?php

declare(strict_types=1);

namespace App\Framework\Templating;

interface TemplateFileGuesserInterface
{
    /**
     * Guess template file path.
     *
     * @param string $view
     *
     * @return string
     */
    public function guess(string $view): string;
}
