<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UsersPostsController extends Controller
{
    public function index(): Factory|View|Application
    {
        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $sort */
        $sort = request('sort') ?? 'DESC';

        $user = auth()->user();

        if ($user) {
            return view('user.posts', [
                'posts' => Post::filterForCreator(['search' => request(['search']), 'id' => $user->id])
                    ->orderBy($by, $sort)
                    ->paginate(25)
                    ->onEachSide(1),
            ]);
        }

        abort(404);
    }
}
