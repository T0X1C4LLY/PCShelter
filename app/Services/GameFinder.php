<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Game;
use App\Models\Review;
use App\Services\Interfaces\Search as SearchInterface;
use App\ValueObjects\DateRange;
use App\ValueObjects\FinderParams;

class GameFinder implements SearchInterface
{
    public function findGames(FinderParams $params, DateRange $range): array
    {
        $games = $this->getFilteredGames($params->filters, $range);

        $gameIds = array_map(static fn ($game) => $game['id'], $games);

        $reviews = $this->getGroupedReviews($params->types, $gameIds);

        return $this->sortGamesByBest($reviews, $games);
    }

    private function getFilteredGames(array $filters, DateRange $range): array
    {
        /** @var Game[] $games */
        $games = Game::select([
                'id',
                'steam_appid',
                'name',
                'release_date',
                'header_image',
            ])
            ->filterForGameFinder($filters)
            ->get();

        $gamesByDate = [];

        foreach ($games as $game) {
            if ($game->isInDateRange($range)) {
                $gamesByDate[$game->id] = $game->toArray();
            }
        }

        return $gamesByDate;
    }

    private function getGroupedReviews(array $types, array $gameIds): array
    {
        $types[] = 'game_id';

        $reviews = Review::select($types)
            ->whereIn('game_id', $gameIds)
            ->get();

        $groupedReviews = [];

        foreach ($reviews as $review) {
            $categories = $review->toArray();
            $gameId = $review['game_id'];
            foreach ($categories as $key => $value) {
                if ($key === 'game_id') {
                    break;
                }
                $groupedReviews[$gameId][$key][] = $value;
            }
        }

        return $groupedReviews;
    }

    private function sortGamesByBest(array $reviews, array $games): array
    {
        $total = [];

        foreach ($reviews as $gameId => $review) {
            $total[$gameId] = 0;

            /** @var array $arrayOfGrades */
            foreach ($review as $reviewCategory => $arrayOfGrades) {
                $meanGrade = (float) number_format(
                    (array_sum($arrayOfGrades) / count($arrayOfGrades)),
                    2,
                    '.',
                    ''
                );
                $total[$gameId] += $meanGrade;
                $reviews[$gameId][$reviewCategory] = $meanGrade;
            }
        }

        uasort($total, static fn ($a, $b) => $b <=> $a);

        $gamesToReturn = [];
        foreach ($total as $id => $value) {
            $games[$id]['reviews'] = $reviews[$id];
            $gamesToReturn[] = $games[$id];
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
