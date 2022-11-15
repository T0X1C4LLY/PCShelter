<?php

declare(strict_types=1);

namespace App\Exceptions;

class SteamResponseException extends \Exception
{
    public static function byInvalidResponse(): self
    {
        return new self('Something went wrong while retrieving data from Steam');
    }
}
