<?php

declare(strict_types=1);

namespace App\Exceptions;

class InvalidOrderArgument extends \Exception
{
    public static function byInvalidArgument(string $order, string $by): self
    {
        return new self(sprintf('Cannot order %s by %s', $order, $by));
    }
}
