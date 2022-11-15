<?php

namespace App\Services\Interfaces;

use App\ValueObjects\DateRange;

interface Search
{
    /**
     * @param string[] $genres
     * @param string[] $categories
     * @param string[] $types
     * @param DateRange $range
     * @return array{
     *     id: string,
     *     steam_appid: int,
     *     name: string,
     *     release_date: array{coming_soon: boolean, date: string},
     *     header_image: string,
     *     reviews: array<string, array{values: int[], sum: int, count: int}>
     * }[]
     */
    public function findGames(array $genres, array $categories, array $types, DateRange $range): array;
}
