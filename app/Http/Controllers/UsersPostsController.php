<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsersPostsController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        /** @var string $by */
        $by = $request->input('by', 'created_at');

        /** @var string $sort */
        $sort = $request->input('sort', 'DESC');

        /** @var User $user */
        $user = $request->user();

        return view('user.posts', [
            'posts' => Post::select([
                    'slug',
                    'title',
                    'posts.created_at',
                    DB::raw('COALESCE(COUNT(comments.id),0) as comments'),
                ])
                ->leftJoin('comments', 'comments.post_id', 'posts.id')
                ->filterForCreator(['search' => request(['search']), 'id' => $user->id])
                ->groupBy(['title', 'slug', 'posts.created_at'])
                ->orderBy($by, $sort)
                ->paginate(25)
                ->onEachSide(1),
        ]);
    }

    public function create(): Application|View|Factory
    {
        $categories = Category::all(['id', 'name'])->toArray();

        return view('user.create', ['categories' => $categories]);
    }

    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        /** @var UploadedFile $file */
        $file = $request->file('thumbnail');

        /** @var User $user */
        $user = $request->user();

        $attributes = array_merge($this->validatePost($request), [
            'user_id' => $user->id,
            'thumbnail' => $file->store('thumbnails'),
        ]);
        Post::create($attributes);

        return redirect('/')->with('success', 'Your post has been successfully posted');
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $attributes = $this->validatePost($request, $post);

        $file = $request->file('thumbnail');

        if (isset($attributes['thumbnail']) && $file instanceof UploadedFile) {
            $attributes['thumbnail'] = $file->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success', 'Post Updated');
    }

    protected function validatePost(Request $request, ?Post $post = null): array
    {
        $post ??= new Post();

        return $request->validate([
            'title' => ['required'],
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => ['required'],
            'body' => ['required'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ]);
    }
}
