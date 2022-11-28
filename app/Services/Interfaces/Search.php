<?php

namespace App\Services\Interfaces;

use App\ValueObjects\DateRange;
use App\ValueObjects\FinderParams;

interface Search
{
    /**
     * @return array{
     *     id: string,
     *     steam_appid: int,
     *     name: string,
     *     release_date: array{
     *          coming_soon: boolean,
     *          date: string,
     *     },
     *     header_image: string,
     *     reviews: array<string, array{
     *          values: int[],
     *          sum: int,
     *          count: int,
     *     }>,
     * }[]
     */
    public function findGames(FinderParams $params, DateRange $range): array;
}
