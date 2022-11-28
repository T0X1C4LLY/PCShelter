<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Enums\AdminPostsOrderByTypes;
use App\Enums\SortOrder;

class AdminPostsOrderBy
{
    public readonly SortOrder $order;
    public readonly AdminPostsOrderByTypes $by;

    public function __construct(
        string $order,
        string $by,
    ) {
        $this->order = SortOrder::from($order);
        $this->by = AdminPostsOrderByTypes::from($by);
    }
}
