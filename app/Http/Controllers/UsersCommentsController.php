<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UsersCommentsController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        /** @var string $by */
        $by = $request->input('by', 'created_at');

        /** @var string $sort */
        $sort = $request->input('sort', 'DESC');

        /** @var User $user */
        $user = $request->user();

        return view('user.comments', [
            'comments' => Comment::filter(['search' => request(['search']), 'id' => $user->id])
                ->orderBy($by, $sort)
                ->paginate(25)
                ->onEachSide(1),
        ]);
    }
}
