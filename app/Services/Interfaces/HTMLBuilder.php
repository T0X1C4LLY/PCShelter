<?php

namespace App\Services\Interfaces;

interface HTMLBuilder
{
    /**
     * @param array{
     *     steam_appid: string,
     *     header_image: string,
     *     name: string,
     * }[] $games
     */
    public function createGameDivs(array $games): string;
}
