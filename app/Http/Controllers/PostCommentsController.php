<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function store(Post $post): RedirectResponse
    {
        request()->validate([
            'body' => ['required']
        ]);

        $user = request()->user();
        if ($user instanceof User) {
            $post->comments()->create([
                'user_id' => $user->id,
            'body' => request('body')
        ]);
        }


        return back();
    }
}
