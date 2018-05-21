<?php

declare(strict_types=1);

namespace App\Queue\Processor;

use App\Queue\Message\MessageInterface;
use App\Queue\Message\NumberMessage;

class NumberProcessor extends AbstractProcessor
{
    protected function doProcess(MessageInterface $message): void
    {
        /** @var NumberMessage $message */
        $random = random_int(1, 3);

        if (1 !== $random) {
            throw new \LogicException(sprintf('Failed message process'));
        }
    }

    public function isSupported(MessageInterface $message): bool
    {
        return $message instanceof NumberMessage;
    }
}
