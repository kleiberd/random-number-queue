<?php

declare(strict_types=1);

namespace App\Http;

class JsonResponse extends Response
{
    public function getContent(): string
    {
        return json_encode($this->content);
    }

    public function sendContent(): void
    {
        echo json_encode($this->content);
    }
}
