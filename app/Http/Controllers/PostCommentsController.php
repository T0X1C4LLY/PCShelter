<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $request->validate(['body' => ['required']]);

        /** @var User $user */
        $user = $request->user();

        $post->comments()->create([
            'user_id' => $user->id,
            'body' => $request->input('body')
        ]);

        return back(201)->with('success', 'Your comment has been successfully posted');
    }
}
