<?php

namespace App\Services\Interfaces;

use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\AdminUsersOrderBy;
use App\ValueObjects\PaginationInfo;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModelPaginator
{
    public function posts(AdminPostsOrderBy $orderBy, PaginationInfo $pagination, string $search): LengthAwarePaginator;

    public function users(AdminUsersOrderBy $orderBy, PaginationInfo $pagination): LengthAwarePaginator;

    public function games(PaginationInfo $pagination, string $search): LengthAwarePaginator;

    public function postsToShow(PaginationInfo $pagination, string $search, string $category, string $author): LengthAwarePaginator;
}
