<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\IsEnum;

enum AdminPostsOrderByTypes: string
{
    use IsEnum;

    case TITLE = 'title';
    case COMMENTS = 'comments';
    case CREATED_AT = 'created_at';
}
