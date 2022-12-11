<?php

namespace App\Traits;

trait IsEnum
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
