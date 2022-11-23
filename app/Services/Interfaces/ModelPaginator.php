<?php

namespace App\Services\Interfaces;

use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\AdminUsersOrderBy;
use App\ValueObjects\Page;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModelPaginator
{
    public function posts(AdminPostsOrderBy $orderBy, Page $page, string $search): LengthAwarePaginator;

    public function users(AdminUsersOrderBy $orderBy, Page $page): LengthAwarePaginator;

    public function games(Page $page, string $search): LengthAwarePaginator;

    public function postsToShow(Page $page, string $search, string $category, string $author): LengthAwarePaginator;
}
