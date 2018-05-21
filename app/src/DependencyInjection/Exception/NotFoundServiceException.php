<?php

declare(strict_types=1);

namespace App\DependencyInjection\Exception;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundServiceException extends \Exception implements NotFoundExceptionInterface
{
}
