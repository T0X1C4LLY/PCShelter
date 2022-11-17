<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\ArrayPagination;
use App\Models\Game;
use App\Models\Post;
use App\Models\User;
use App\Services\Interfaces\ModelPaginator as ModelPaginatorInterface;
use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\AdminUsersOrderBy;
use App\ValueObjects\PaginationInfo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function users(AdminUsersOrderBy $orderBy, PaginationInfo $pagination): LengthAwarePaginator
    {
        /** @var int $total */
        $total = DB::scalar('SELECT count(id) FROM users');

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
            ->skip(($pagination->page - 1) * $pagination->perPage)
            ->take($pagination->perPage)
            ->get()
            ->toArray();

        return ArrayPagination::paginate($users, $total, $pagination->page, $pagination->perPage);
    }

    public function games(PaginationInfo $pagination, string $search): LengthAwarePaginator
    {
        /** @var int $total */
        $total = DB::scalar('SELECT count(id) FROM games');

        $games = Game::select([
            'steam_appid',
            'header_image',
            'name',
        ])
            ->filter(['search' => $search])
            ->orderBy('name')
            ->skip(($pagination->page - 1) * $pagination->perPage)
            ->take($pagination->perPage)
            ->get()
            ->toArray();

        return ArrayPagination::paginate($games, $total, $pagination->page, $pagination->perPage)->onEachSide(1);
    }

    public function postsToShow(PaginationInfo $pagination, ?string $search, ?string $category, ?string $author): LengthAwarePaginator
    {
        /** @var int $total */
        $total = DB::scalar('
            SELECT count(p.id)
            FROM posts p
            JOIN categories c ON p.category_id = c.id
            JOIN users u ON u.id = p.user_id
            WHERE
                (title LIKE :search OR
                body LIKE :search) AND
                u.username LIKE :author AND
                c.name LIKE :category
        ', [
            'search' => '%'.$search.'%',
            'category' => $category ?: '%',
            'author' => $author ?: '%'
        ]);

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
            ->skip(($pagination->page - 1) * $pagination->perPage)
            ->take($pagination->perPage)
            ->get()
            ->toArray();

        return ArrayPagination::paginate($posts, $total, $pagination->page, $pagination->perPage);
    }
}
