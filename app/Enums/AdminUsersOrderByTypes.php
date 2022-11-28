<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum AdminUsersOrderByTypes: string
{
    use EnumValuesTrait;

    case USERNAME = 'username';
    case NAME = 'name';
    case CREATED_AT = 'created_at';
}
