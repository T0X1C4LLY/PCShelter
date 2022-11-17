<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidPaginationInfoException;
use App\Models\Post;
use App\Services\Interfaces\ModelPaginator;
use App\ValueObjects\PaginationInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private readonly ModelPaginator $paginator)
    {
    }

    public function index(Request $request): Factory|View|Application|RedirectResponse
    {
        $perPage = 15;

        /** @var int $page */
        $page = $request->input('page', 1);

        /** @var string $search */
        $search = $request->input('search');

        /** @var string $category */
        $category = $request->input('category');

        /** @var string $author */
        $author = $request->input('author');

        try {
            $paginationInfo = new PaginationInfo($page, $perPage);
        } catch (InvalidPaginationInfoException $e) {
            return back()->with('failure', $e->getMessage());
        }

        return view('posts.index', [
            'posts' => $this->paginator
                ->postsToShow($paginationInfo, $search, $category, $author)
                ->withQueryString(),
        ]);
    }

    public function show(Post $post): Factory|View|Application
    {
        return view('posts.show', ['post' => $post]);
    }
}
