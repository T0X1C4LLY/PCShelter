<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ReviewCategory;
use App\Exceptions\InvalidDataRangeException;
use App\Models\GameCategory;
use App\Models\Genre;
use App\Rules\GreaterOrEqualIfExists;
use App\Services\Interfaces\Search;
use App\ValueObjects\DateRange;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameFinderController extends Controller
{
    public function __construct(private readonly Search $search)
    {
    }

    public function index(): Factory|View|Application
    {
        return view('gameFinder.index', [
            'genres' => Genre::all(),
            'categories' => GameCategory::all(),
            'reviewCategories' => ReviewCategory::values(),
        ]);
    }

    public function show(Request $request): Factory|View|Application|RedirectResponse
    {
        $this->assertValid($request);

        /** @var string $dateFrom */
        $dateFrom = $request->request->get('dateFrom') ?? '';

        /** @var string $dateTo */
        $dateTo = $request->request->get('dateTo') ?? '';

        $genre = $request->request->all('genre');
        $category = $request->request->all('category');
        $type = $request->request->all('type');

        try {
            return view('gameFinder.show', [
                'games' => $this->search->findGames(
                    $genre,
                    $category,
                    $type,
                    new DateRange($dateFrom, $dateTo)
                ),
            ]);
        } catch (InvalidDataRangeException $e) {
            return back()->with('failure', $e->getMessage());
        }
    }

    private function assertValid(Request $request): void
    {
        $request->validate([
            'genre' => ['required'],
            'category' => ['required'],
            'type' => ['required'],
            'dateFrom' => ['integer',
                'nullable',
                sprintf(
                    'between:1950,%d',
                    date('Y')
                ),
            ],
            'dateTo' => [
                'integer',
                'nullable',
                sprintf('between:1950,%d', date('Y')),
                new GreaterOrEqualIfExists('dateFrom'),
            ],
        ]);
    }
}
