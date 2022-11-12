<?php

namespace App\Services\Interfaces;

use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\PaginationInfo;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModelPaginator
{
    public function posts(AdminPostsOrderBy $orderBy, PaginationInfo $pagination, string $search): LengthAwarePaginator;
}
