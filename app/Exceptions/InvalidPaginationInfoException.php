<?php

declare(strict_types=1);

namespace App\Exceptions;

class InvalidPaginationInfoException extends \Exception
{
    public static function byInvalidArgument(): self
    {
        return new self('Page number and per page have to be greater than 0');
    }
}
