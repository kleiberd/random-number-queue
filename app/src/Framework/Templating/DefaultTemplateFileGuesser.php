<?php

declare(strict_types=1);

namespace App\Framework\Templating;

class DefaultTemplateFileGuesser implements TemplateFileGuesserInterface
{
    private $templateDirPath;

    public function __construct(string $templateDirPath)
    {
        $this->templateDirPath = $templateDirPath;
    }

    public function guess(string $view): string
    {
        return strtr('{dirPath}{sep}{file}{ext}', [
            '{dirPath}' => $this->templateDirPath,
            '{sep}' => DIRECTORY_SEPARATOR,
            '{file}' => str_replace('.', DIRECTORY_SEPARATOR, $view),
            '{ext}' => '.html.php',
        ]);
    }
}
