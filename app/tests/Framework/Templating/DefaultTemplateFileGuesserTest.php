<?php

declare(strict_types=1);

namespace App\Tests\Framework\Templating;

use App\Framework\Templating\DefaultTemplateFileGuesser;
use App\Framework\Templating\TemplateFileGuesserInterface;
use PHPUnit\Framework\TestCase;

class DefaultTemplateFileGuesserTest extends TestCase
{
    private const TEMPLATE_DIR = '/tmp/template';

    /**
     * @dataProvider getGuessDataProvider
     */
    public function testGuess(string $view, string $templateFile): void
    {
        $guesser = $this->getDefaultTemplateFileGuesser();

        $this->assertEquals($templateFile, $guesser->guess($view));
    }

    public function getGuessDataProvider(): array
    {
        return [
            ['test.index', self::TEMPLATE_DIR.DIRECTORY_SEPARATOR.'test'.DIRECTORY_SEPARATOR.'index'.'.html.php'],
            ['test.sub.folder.index', strtr('{t}{s}{f1}{s}{f2}{s}{f3}{s}{f}', [
                '{s}' => DIRECTORY_SEPARATOR,
                '{t}' => self::TEMPLATE_DIR,
                '{f1}' => 'test',
                '{f2}' => 'sub',
                '{f3}' => 'folder',
                '{f}' => 'index.html.php',
            ])],
        ];
    }

    private function getDefaultTemplateFileGuesser(): TemplateFileGuesserInterface
    {
        return new DefaultTemplateFileGuesser(self::TEMPLATE_DIR);
    }
}
