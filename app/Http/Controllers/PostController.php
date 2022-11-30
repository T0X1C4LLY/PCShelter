<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidPaginationInfoException;
use App\Models\Category;
use App\Models\Post;
use App\Services\Interfaces\ModelPaginator;
use App\ValueObjects\Page;
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

        /** @var string|null $search */
        $search = $request->input('search');

        /** @var string|null $category */
        $category = $request->input('category');

        /** @var string|null $author */
        $author = $request->input('author');

        try {
            $paginationInfo = new Page($page, $perPage);
        } catch (InvalidPaginationInfoException $e) {
            return back()->with('failure', $e->getMessage());
        }

        $currentCategory = null;

        /** @var array{name: string, slug: string}[] $categories */
        $categories = Category::all(['name', 'slug'])->toArray();

        foreach ($categories as $cat) {
            if ($request->fullUrlIs("*?category={$cat['slug']}*")) {
                $currentCategory = $cat;
            }
        }

        return view('posts.index', [
            'posts' => $this->paginator
                ->postsToShow($paginationInfo, $search, $category, $author)
                ->withQueryString(),
            'categories' => $categories,
            'currentCategory' => $currentCategory,
        ]);
    }

    public function show(Post $post): Factory|View|Application
    {
        return view('posts.show', ['post' => $post]);
    }
}
