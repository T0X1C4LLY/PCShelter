<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\ArrayPagination;
use App\Models\Post;
use App\Services\Interfaces\ModelPaginator as ModelPaginatorInterface;
use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\PaginationInfo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ModelPaginator implements ModelPaginatorInterface
{
    public function posts(AdminPostsOrderBy $orderBy, PaginationInfo $pagination, string $search): LengthAwarePaginator
    {
        /** @var int $total */
        $total = DB::scalar('
            SELECT count(id)
            FROM posts
            WHERE title ILIKE :search
        ', [
            'search' => '%'.$search.'%'
        ]);

        $posts = Post::select([
            'title',
            'slug',
            'posts.id',
            'posts.created_at',
            DB::raw('COALESCE(COUNT(comments.id),0) as comments')
        ])
            ->leftJoin('comments', 'comments.post_id', 'posts.id')
            ->filter(['admin_search' => $search])
            ->groupBy(['title', 'slug', 'posts.id'])
            ->orderBy($orderBy->by, $orderBy->order)
            ->skip(($pagination->page - 1) * $pagination->perPage)
            ->take($pagination->perPage)
            ->get()
            ->toArray();

        return ArrayPagination::paginate($posts, $total, $pagination->page, $pagination->perPage);
    }
}
