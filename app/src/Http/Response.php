<?php

declare(strict_types=1);

namespace App\Http;

class Response
{
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function sendContent(): void
    {
        echo $this->content;
    }

    public function send(): void
    {
        $this->sendContent();
    }
}
