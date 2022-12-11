<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\IsEnum;

enum SortOrder: string
{
    use IsEnum;

    case ASCENDING = 'ASC';
    case DESCENDING = 'DESC';
}
