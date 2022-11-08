<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ReviewCategory;
use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Genre;
use App\Models\Review;
use DateTimeImmutable;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GameFinderController extends Controller
{
    public function index(): Factory|View|Application
    {
        $reviewCategories = ReviewCategory::allValues();

        return view('gameFinder.index', [
            'genres' => Genre::all(),
            'categories' => GameCategory::all(),
            'reviewCategories' => $reviewCategories,
        ]);
    }

    public function show(Request $request): View|\Illuminate\Contracts\View\Factory|string|Application
    {
        $genre = $request->request->all('genre');
        $category = $request->request->all('category');
        $type = $request->request->all('type');
        $dateFrom = $request->request->get('dateFrom');
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
            foreach ($games as $game) {
                $releaseDate = DateTimeImmutable::createFromFormat('d M, Y', $game['release_date']['date']);
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
                $releaseDate = DateTimeImmutable::createFromFormat('d M, Y', $game['release_date']['date']);
                $to = DateTimeImmutable::createFromFormat('Y', $dateTo);

                $releaseDate = $releaseDate->modify('January 1 00:00:00');
                $to = $to->modify('January 1 00:00:00');

                if ($releaseDate <= $to) {
                    $gamesByDate[] = $game;
                }
            }
        }

        $columns = $type;

        if (in_array('all', $type, true)) {
            $columns = ReviewCategory::allValues();
        }

        $columns[] = 'game_id';

        $reviews = Review::select($columns)
            ->whereIn('game_id', array_map(static fn (Game $game) => $game['id'], $gamesByDate))
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
                $sortedReviews[$gameId][$key]['sum'] = array_key_exists('sum', $sortedReviews[$gameId][$key]) ? $sortedReviews[$gameId][$key]['sum'] + $value : 0;
                $sortedReviews[$gameId][$key]['count'] = array_key_exists('count', $sortedReviews[$gameId][$key]) ? $sortedReviews[$gameId][$key]['count'] += 1 : 1;
            }
        }

        $total = [];
        foreach ($sortedReviews as $key => $review) {
            $total[$key] = 0;
            foreach($review as $k => $value) {
                $total[$key] += ($value['sum'] / $value['count']);
            }
        }

        uasort($total, static fn($a, $b) => $b <=> $a);

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
        ]);
    }
}
