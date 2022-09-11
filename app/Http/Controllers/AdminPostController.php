<?php

namespace App\Http\Controllers;

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
        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $sort */
        $sort = request('sort') ?? 'DESC';


        return view('admin.posts.index', [
//            'posts' => Post::filter(request(['admin_search']))
//                ->orderBy($by, $sort)
//                ->paginate(25)
//                ->onEachSide(1),

            'posts' => Post::select(['title', 'slug', 'posts.id', 'posts.created_at', DB::raw('COALESCE(COUNT(comments.id),0) as comments')])
                ->leftJoin('comments', 'comments.post_id', '=', 'posts.id')
                ->filter(request(['admin_search']))
                ->groupBy(['title', 'slug', 'posts.id'])
                ->orderBy($by, $sort)
                ->paginate(25)
                ->onEachSide(1),

//            'posts' => DB::select(DB::raw('SELECT p.id, slug, title, p.created_at, COALESCE(c.amount,0) as amount
//                FROM posts p
//                LEFT JOIN (SELECT COUNT(id) as amount, post_id FROM comments GROUP BY post_id) c
//                ON p.id = c.post_id')),

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
