<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum AdminPostsOrderByTypes: string
{
    use EnumValuesTrait;

    case TITLE = 'title';
    case COMMENTS = 'comments';
    case CREATED_AT = 'created_at';
}
