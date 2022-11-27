<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidOrderArgumentException;
use App\Exceptions\InvalidPaginationInfoException;
use App\Models\Category;
use App\Models\Post;
use App\Services\Interfaces\ModelPaginator;
use App\ValueObjects\AdminPostsOrderBy;
use App\ValueObjects\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function __construct(private readonly ModelPaginator $paginator)
    {
    }

    public function index(Request $request): Factory|View|Application|RedirectResponse
    {
        $perPage = 25;

        /** @var string $by */
        $by = $request->input('by', 'created_at');

        /** @var string $order */
        $order = $request->input('order', 'DESC');

        /** @var int $page */
        $page = $request->input('page', 1);

        /** @var string|null $search */
        $search = $request->input('admin_search');

        try {
            $orderBy = new AdminPostsOrderBy($order, $by);
            $paginationInfo = new Page($page, $perPage);
        } catch (InvalidOrderArgumentException|InvalidPaginationInfoException $e) {
            return back()->with('failure', $e->getMessage());
        }

        return view('admin.posts.index', [
            'posts' => $this->paginator->posts($orderBy, $paginationInfo, $search),
        ]);
    }

    public function edit(Post $post): Factory|View|Application
    {
        $categories = Category::get(['id', 'name'])->toArray();

        return view('admin.posts.edit', [
            'post' => $post->toArray(),
            'categories' => $categories,
        ]);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('success', "Post deleted successfully");
    }
}
