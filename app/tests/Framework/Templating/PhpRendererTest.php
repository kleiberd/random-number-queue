<?php

declare(strict_types=1);

namespace App\Tests\Framework\Templating;

use App\Framework\Templating\PhpRenderer;
use App\Framework\Templating\TemplateFileGuesserInterface;
use PHPUnit\Framework\TestCase;

class PhpRendererTest extends TestCase
{
    public function testRender(): void
    {
        $renderer = $this->getRenderer();

        $this->assertEquals('Hello David!', $renderer->render('', ['name' => 'David']));
    }

    private function getRenderer(): PhpRenderer
    {
        return new PhpRenderer($this->getMockTemplateFileGuesser());
    }

    private function getMockTemplateFileGuesser(): TemplateFileGuesserInterface
    {
        $mock = $this->createMock(TemplateFileGuesserInterface::class);

        $mock
            ->expects($this->any())
            ->method('guess')
            ->willReturn(__DIR__.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.'phprenderer.html.php');

        return $mock;
    }
}
