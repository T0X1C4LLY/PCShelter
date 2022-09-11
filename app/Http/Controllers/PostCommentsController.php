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
        /** @var Request $request */
        $request = request();

        $request->validate([
            'body' => ['required']
        ]);

        $user = $request->user();
        if ($user instanceof User) {
            $post->comments()->create([
                'user_id' => $user->id,
                'body' => request('body')
            ]);
            return back(201)->with('success', 'You comment has been successfully posted');
        }

        return back()->with('failure', 'Something went wrong, please try again');
    }
}
