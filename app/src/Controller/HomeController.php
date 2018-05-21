<?php

declare(strict_types=1);

namespace App\Controller;

use App\Framework\Templating\ResponseRendererInterface;
use App\Http\Response;

class HomeController
{
    private $renderer;

    public function __construct(ResponseRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index(): Response
    {
        return $this->renderer->render('home.index');
    }
}
