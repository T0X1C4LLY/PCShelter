<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Enums\AdminUsersOrderByTypes;
use App\Enums\SortOrder;

class AdminUsersOrderBy
{
    public readonly SortOrder $order;
    public readonly AdminUsersOrderByTypes $by;

    public function __construct(
        string $order,
        string $by,
    ) {
        $this->order = SortOrder::from($order);
        $this->by = AdminUsersOrderByTypes::from($by);
    }
}
