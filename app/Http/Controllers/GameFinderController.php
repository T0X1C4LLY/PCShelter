<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ReviewCategory;
use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Genre;
use App\Models\Review;
use App\Rules\GreaterOrEqualIfExists;
use DateTimeImmutable;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GameFinderController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('gameFinder.index', [
            'genres' => Genre::all(),
            'categories' => GameCategory::all(),
            'reviewCategories' => ReviewCategory::values(),
        ]);
    }

    public function show(Request $request): View|\Illuminate\Contracts\View\Factory|string|Application
    {
        $this->assertValid();

        $genre = $request->request->all('genre');
        $category = $request->request->all('category');
        $type = $request->request->all('type');
        /** @var string $dateFrom */
        $dateFrom = $request->request->get('dateFrom');
        /** @var string $dateTo */
        $dateTo = $request->request->get('dateTo');

        $filters = [];

        if (!in_array('all', $genre, true)) {
            $filters['genre'] = $genre;
        }

        if (!in_array('all', $category, true)) {
            $filters['category'] = $category;
        }

        $games = Game::select()
            ->filterForGameFinder($filters)
            ->get()
            ->all();

        $gamesByDate = $games;

        if ($dateFrom) {
            $gamesByDate = [];
            /** @var array{
             *     id: string,
             *     steam_appid: string,
             *     name: string,
             *     categories: string[],
             *     genres: string[],
             *     release_date: array{coming_soon: boolean, date: string},
             *     header_image: string,
             * } $game
             */
            foreach ($games as $game) {
                if ($game['release_date']['coming_soon']) {
                    continue;
                }

                /** @var DateTimeImmutable $releaseDate */
                $releaseDate = DateTimeImmutable::createFromFormat('d M, Y', $game['release_date']['date']);
                /** @var DateTimeImmutable $from */
                $from = DateTimeImmutable::createFromFormat('Y', $dateFrom);
                $releaseDate = $releaseDate->modify('January 1 00:00:00');
                $from = $from->modify('January 1 00:00:00');

                if ($releaseDate >= $from) {
                    $gamesByDate[] = $game;
                }
            }
        }

        if ($dateTo) {
            $gamesFrom = $gamesByDate;
            $gamesByDate = [];
            foreach ($gamesFrom as $game) {
                if ($game['release_date']['coming_soon']) {
                    continue;
                }

                /** @var DateTimeImmutable $releaseDate */
                $releaseDate = DateTimeImmutable::createFromFormat('d M, Y', $game['release_date']['date']);
                /** @var DateTimeImmutable $to */
                $to = DateTimeImmutable::createFromFormat('Y', $dateTo);

                $releaseDate = $releaseDate->modify('January 1 00:00:00');
                $to = $to->modify('January 1 00:00:00');

                if ($releaseDate <= $to) {
                    $gamesByDate[] = $game;
                }
            }
        }

        $columns = $type;
        $columns[] = 'game_id';

        $reviews = Review::select($columns)
            ->whereIn('game_id', array_map(static fn ($game) => $game['id'], $gamesByDate))
            ->get()
            ->all();

        $sortedReviews = [];

        foreach ($reviews as $review) {
            $categories = $review->attributesToArray();
            $gameId = $review['game_id'];
            foreach ($categories as $key => $value) {
                if ($key === 'game_id') {
                    break;
                }
                $sortedReviews[$gameId][$key]['values'][] = $value;
                $sortedReviews[$gameId][$key]['sum'] = array_key_exists('sum', $sortedReviews[$gameId][$key]) ?
                    $sortedReviews[$gameId][$key]['sum'] + $value :
                    0;
                $sortedReviews[$gameId][$key]['count'] = array_key_exists('count', $sortedReviews[$gameId][$key]) ?
                    $sortedReviews[$gameId][$key]['count'] += 1 :
                    1;
            }
        }

        $total = [];
        foreach ($sortedReviews as $key => $review) {
            $total[$key] = 0;
            foreach ($review as $k => $value) {
                $temp = (float) number_format(
                    ($value['sum'] / $value['count']),
                    2,
                    '.',
                    ''
                );
                $total[$key] += $temp;
                $sortedReviews[$key][$k]['total'] = $temp;
            }
        }

        uasort($total, static fn ($a, $b) => $b <=> $a);

        $gamesToReturn = [];

        foreach ($total as $id => $value) {
            foreach ($gamesByDate as $game) {
                if ($game['id'] === $id) {
                    $gamesToReturn[] = $game;
                }
            }
        }

        return view('gameFinder.show', [
            'games' => $gamesToReturn,
            'reviews' => $sortedReviews,
        ]);
    }

    private function assertValid(): void
    {
        /** @var Request $request */
        $request = request();

        $request->validate([
            'genre' => ['required'],
            'category' => ['required'],
            'type' => ['required'],
            'dateFrom' => ['integer', 'nullable', sprintf('between:1950,%d', date('Y'))],
            'dateTo' => ['integer', 'nullable', sprintf('between:1950,%d', date('Y')), new GreaterOrEqualIfExists('dateFrom')],
        ]);
    }
}
