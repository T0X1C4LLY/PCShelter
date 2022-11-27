<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidPaginationInfoException;
use App\Facades\ArrayPagination;
use App\Models\Game;
use App\Models\Post;
use App\Models\User;
use App\Services\Interfaces\ModelPaginator as ModelPaginatorInterface;
use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\AdminUsersOrderBy;
use App\ValueObjects\Page;
use App\ValueObjects\PaginationInfo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ModelPaginator implements ModelPaginatorInterface
{
    /**
     * @throws InvalidPaginationInfoException
     */
    public function posts(AdminPostsOrderBy $orderBy, Page $page, ?string $search): LengthAwarePaginator
    {
        $total = DB::table('posts')->selectRaw('count(id)');

        if ($search) {
            $total->where('title', 'ilike', '%'.$search.'%');
        }

        $total = $total->value('count(id)');

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
            ->skip($page->skip())
            ->take($page->perPage)
            ->get()
            ->toArray();

        /** @var int $total */
        return ArrayPagination::paginate($posts, new PaginationInfo($page, $total));
    }

    /**
     * @throws InvalidPaginationInfoException
     */
    public function users(AdminUsersOrderBy $orderBy, Page $page, ?string $search): LengthAwarePaginator
    {
        $total = DB::table('users')->selectRaw('count(id)');

        if ($search) {
            $total->where('username', 'ilike', '%'.$search.'%');
        }

        $total = $total->value('count(id)');

        $users = User::select([
                'users.id',
                'username',
                'users.name',
                'users.username',
                'email',
                'roles.name AS role',
                'users.created_at'
            ])
            ->filter(request(['admin_search']))
            ->orderBy('users.'.$orderBy->by, $orderBy->order)
            ->join('model_has_roles', 'model_id', 'users.id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->skip($page->skip())
            ->take($page->perPage)
            ->get()
            ->toArray();

        /** @var int $total */
        return ArrayPagination::paginate($users, new PaginationInfo($page, $total));
    }

    public function getPaginatedGames(Page $page, string $search): array
    {
        return Game::select([
                'steam_appid',
                'header_image',
                'name',
            ])
            ->filter(['search' => $search])
            ->orderBy('name')
            ->skip($page->skip())
            ->take($page->perPage)
            ->get()
            ->toArray();
    }

    /**
     * @throws InvalidPaginationInfoException
     */
    public function postsToShow(Page $page, ?string $search, ?string $category, ?string $author): LengthAwarePaginator
    {
        $total = DB::table('posts')
            ->selectRaw('count(posts.id) as quantity')
            ->join('categories', 'categories.id', 'posts.category_id')
            ->join('users', 'users.id', 'posts.user_id');

        if ($search) {
            $total->whereRaw('title LIKE ? OR body LIKE ?', [$search, $search]);
        }

        if ($author) {
            $total->where('users.username', $author);
        }

        if ($category) {
            $total->where('categories.slug', $category);
        }

        $total = $total->value('quantity');

        $posts =  Post::select([
                'posts.id',
                'user_id',
                'category_id',
                'slug',
                'title',
                'thumbnail',
                'excerpt',
                'body',
                'posts.created_at',
                'username',
                'name',
            ])
            ->join('users', 'users.id', 'posts.user_id')
            ->filter(['search' => $search, 'category' => $category, 'author' => $author])
            ->orderBy('posts.created_at', 'DESC')
            ->skip($page->skip())
            ->take($page->perPage)
            ->get()
            ->toArray();

        /** @var int $total */
        return ArrayPagination::paginate($posts, new PaginationInfo($page, $total));
    }
}
