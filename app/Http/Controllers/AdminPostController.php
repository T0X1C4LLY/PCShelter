<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminPostController extends Controller
{
    public function index(): Application|View|Factory
    {
        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $sort */
        $sort = request('sort') ?? 'DESC';

        return view('admin.posts.index', [
            'posts' => Post::filter(request(['admin_search']))
                ->orderBy($by, $sort)
                ->paginate(25)
                ->onEachSide(1),
        ]);
    }

    public function edit(Post $post): Factory|View|Application
    {
        return view('admin.posts.edit', ['post' => $post, 'categories' => Category::all()]);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('success', "Post deleted successfully");
    }
}
