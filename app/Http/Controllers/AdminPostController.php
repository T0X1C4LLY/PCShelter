<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\Auth\AuthManager;

class AdminPostController extends Controller
{
    public function index(): Application|View|Factory
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50),
        ]);
    }
    public function create(): Application|View|Factory
    {
        return view('admin.posts.create');
    }

    public function store(): Redirector|Application|RedirectResponse
    {
//        $attributes = $this->validatePost();
//        $attributes['user_id'] = auth()->id();
//        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        /** @var Request|null $request */
        $request = request();

        if (!is_null($request)) {
            /** @var UploadedFile $file */
            $file = $request->file('thumbnail');
            $attributes = array_merge($this->validatePost(), [
                'user_id' => auth()->id(),
                'thumbnail' => $file->store('thumbnails'),
            ]);
            Post::create($attributes);
        }



        return redirect('/');
    }

    public function edit(Post $post): Factory|View|Application
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post): RedirectResponse
    {
        $attributes = $this->validatePost($post);

        /** @var Request|null $request */
        $request = request();

        if (!is_null($request)) {
            $file = $request->file('thumbnail');
            if (isset($attributes['thumbnail']) && $file instanceof UploadedFile) {
                $attributes['thumbnail'] = $file->store('thumbnails');
            }
            $post->update($attributes);
        }

        return back()->with('success', 'Post Updated');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('success', "Post deleted successfully");
    }

    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post();

        /** @var Request $request */
        $request = request();

        return $request->validate([
            'title' => ['required'],
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => ['required'],
            'body' => ['required'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'published_at' => 'required'
        ]);
    }
}
