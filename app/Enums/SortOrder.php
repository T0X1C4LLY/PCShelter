<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum SortOrder: string
{
    use EnumValuesTrait;

    case ASCENDING = 'ASC';
    case DESCENDING = 'DESC';
}
