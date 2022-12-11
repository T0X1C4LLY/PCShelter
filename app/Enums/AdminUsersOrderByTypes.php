<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\IsEnum;

enum AdminUsersOrderByTypes: string
{
    use IsEnum;

    case USERNAME = 'username';
    case NAME = 'name';
    case CREATED_AT = 'created_at';
}
