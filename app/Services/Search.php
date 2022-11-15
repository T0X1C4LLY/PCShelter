<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Game;
use App\Models\Review;
use App\Services\Interfaces\Search as SearchInterface;
use App\ValueObjects\DateRange;
use DateTimeImmutable;

class Search implements SearchInterface
{
    public function findGames(array $genres, array $categories, array $types, DateRange $range): array
    {
        $filters = [];

        if (!in_array('all', $genres, true)) {
            $filters['genre'] = $genres;
        }

        if (!in_array('all', $categories, true)) {
            $filters['category'] = $categories;
        }

        $games = Game::select(['id', 'steam_appid', 'name', 'release_date', 'header_image'])
            ->filterForGameFinder($filters)
            ->get()
            ->toArray();

        $gamesByDate = $games;

        if ($range->from) {
            $gamesByDate = [];
            /** @var array{
             *     id: string,
             *     steam_appid: string,
             *     name: string,
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
                $releaseDate = $releaseDate->modify('January 1 00:00:00');

                if ($releaseDate >= $range->from) {
                    $gamesByDate[] = $game;
                }
            }
        }

        if ($range->to) {
            $gamesFrom = $gamesByDate;
            $gamesByDate = [];
            /** @var array{
             *     id: string,
             *     steam_appid: string,
             *     name: string,
             *     release_date: array{coming_soon: boolean, date: string},
             *     header_image: string,
             * } $game
             */
            foreach ($gamesFrom as $game) {
                if ($game['release_date']['coming_soon']) {
                    continue;
                }

                /** @var DateTimeImmutable $releaseDate */
                $releaseDate = DateTimeImmutable::createFromFormat('d M, Y', $game['release_date']['date']);
                $releaseDate = $releaseDate->modify('January 1 00:00:00');

                if ($releaseDate <= $range->to) {
                    $gamesByDate[] = $game;
                }
            }
        }

        $columns = $types;
        $columns[] = 'game_id';

        /** @var array{
         *     id: string,
         *     steam_appid: string,
         *     name: string,
         *     release_date: array{coming_soon: boolean, date: string},
         *     header_image: string,
         * }[] $gamesByDate */
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
                    $game['reviews'] = $sortedReviews[$game['id']];
                    $gamesToReturn[] = $game;
                }
            }
        }

        /** @var array{
         *     id: string,
         *     steam_appid: int,
         *     name: string,
         *     release_date: array{coming_soon: boolean, date: string},
         *     header_image: string,
         *     reviews: array<string, array{values: int[], sum: int, count: int}>
         * }[] $gamesToReturn */
        return $gamesToReturn;
    }
}
