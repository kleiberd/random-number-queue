<?php

declare(strict_types=1);

use App\Http\Factory\RequestFactory;
use App\Kernel\Kernel;

require __DIR__.'/../vendor/autoload.php';

$response = (new Kernel())->handleRequest(RequestFactory::createFromGlobals());
$response->send();
