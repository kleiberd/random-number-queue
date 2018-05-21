<?php

declare(strict_types=1);

namespace App\Framework\Templating;

use App\Framework\Templating\Exception\TemplateNotFoundException;

class PhpRenderer implements RendererInterface
{
    /**
     * @var TemplateFileGuesserInterface
     */
    private $templateFileGuesser;

    public function __construct(TemplateFileGuesserInterface $templateFileGuesser)
    {
        $this->templateFileGuesser = $templateFileGuesser;
    }

    public function render(string $view, array $parameters = []): string
    {
        $filePath = $this->templateFileGuesser->guess($view);

        if (file_exists($filePath)) {
            return $this->evaluate($filePath, $parameters);
        }

        throw new TemplateNotFoundException(sprintf('The template %s does not exist.', $filePath));
    }

    private function evaluate(string $filePath, array $parameters): string
    {
        extract($parameters, EXTR_SKIP);

        ob_start();

        require $filePath;

        return ob_get_clean();
    }
}
