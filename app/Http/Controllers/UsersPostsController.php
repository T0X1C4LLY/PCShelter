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

    public function create(): Application|View|Factory
    {
        return view('user.create');
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
            return redirect('/')->with('success', 'Your post has been successfully posted');
        }
        return back()->with('failure', 'Something went wrong, please try again');
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
        ]);
    }
}
