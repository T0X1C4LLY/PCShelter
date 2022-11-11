<?php

namespace App\Http\Controllers;

use App\Facades\ArrayPagination;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminPostController extends Controller
{
    public function index(): Application|View|Factory
    {
        $perPage = 25;

        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $order */
        $order = request('order') ?? 'DESC';

        /** @var int $page */
        $page = request('page') ?? 1;

        /** @var int $total */
        $total = DB::table('posts')
            ->selectRaw('count(id)')
            ->value('count');

        $posts = Post::select([
                'title',
                'slug',
                'posts.id',
                'posts.created_at',
                DB::raw('COALESCE(COUNT(comments.id),0) as comments')
            ])
            ->leftJoin('comments', 'comments.post_id', 'posts.id')
            ->filter(request(['admin_search']))
            ->groupBy(['title', 'slug', 'posts.id'])
            ->orderBy($by, $order)
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->toArray();

        return view('admin.posts.index', [
            'posts' => ArrayPagination::paginate($posts, $total, $page, $perPage)
        ]);
    }

    public function edit(Post $post): Factory|View|Application
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('success', "Post deleted successfully");
    }
}
