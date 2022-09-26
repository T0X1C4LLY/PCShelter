<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GamesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \JsonException
     */
    public function run()
    {
        Game::truncate();

        $gamesFile = file_get_contents("/var/www/html/database/assets/games.json");

        /** @var array{
         *     id: string,
         *     steam_appid: int,
         *     name: string,
         *     categories: string[],
         *     genres: string[],
         *     release_date: array{coming_soon: bool, date: string},
         * }[] $games
         */
        $games = json_decode($gamesFile, true, 512, JSON_THROW_ON_ERROR);

        array_map(/**
         * @param array{
         *     id: string,
         *     steam_appid: int,
         *     name: string,
         *     categories: string[],
         *     genres: string[],
         *     release_date: array{coming_soon: bool, date: string},
         * } $game
         * @return void
         * @throws \JsonException
         */ static function (array $game): void {
            Game::create($game);
        }, $games);
    }
}
