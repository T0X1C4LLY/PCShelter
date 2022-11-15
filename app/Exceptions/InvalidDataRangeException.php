<?php

declare(strict_types=1);

namespace App\Exceptions;

class InvalidDataRangeException extends \Exception
{
    public static function byDataRange(string $from, string $to): self
    {
        return new self(sprintf('Cannot create date range from %s to %s', $from, $to));
    }
}
