<?php

declare(strict_types=1);

namespace App\Other;

use App\Exceptions\SteamResponseException;
use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Genre;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;

class SteamInfo
{
    private array $gameArrayKeys = [
        'name',
        'steam_appid',
        'about_the_game',
        'short_description',
        'header_image',
        'developers',
        'publishers',
        'platforms',
        'categories',
        'genres',
        'screenshots',
        'release_date',
        'pc_requirements'
    ];

    public function __construct()
    {
    }

    /**
     * @throws \JsonException
     * @throws SteamResponseException
     */
    public function getByGameId(int $gameId): array
    {
        /** @var string $data */
        $data = file_get_contents(env('STEAM_URL').$gameId);

        /** @var array $dataAsArray */
        $dataAsArray = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        $dataWithoutKey = array_values($dataAsArray);
        $gameData = $dataWithoutKey[0];

        if (!$gameData['success']) {
            throw SteamResponseException::byInvalidResponse();
        }

        $game = Game::where('steam_appid', $gameId)->first() ?: $this->addGame($gameData['data']);

        $info = [];

        foreach ($this->gameArrayKeys as $key) {
            $info[$key] = $gameData['data'][$key] ?? null;
        }

        // Replace steam URl to PCShelter URL
        $info['about_the_game'] = preg_replace(
            '/("https:\/\/store.steampowered.com\/app)/',
            '"'.URL::to('/games'),
            $info['about_the_game']
        );

        // Delete game title from URL
        $info['about_the_game'] = preg_replace(
            '/(\/[a-zA-Z0-9^\w]*\/")( target="_blank")/',
            '"',
            $info['about_the_game']
        );

        if ($info['release_date']) {
            $info['release_date'] = $info['release_date']['coming_soon'] ? 'Coming Soon' : $info['release_date']['date'];
        }

        $info['reviews'] = $game->getBestAndGeneralReviews();


        return $info;
    }

    public function addGame(array $data): Game
    {
        $genres = array_column($data['genres'], 'description');
        $categories = array_column($data['categories'], 'description');

        $genresInDb = Genre::pluck('name')->toArray();
        $categoriesInDb = GameCategory::pluck('name')->toArray();

        foreach ($genres as $genre) {
            if (!in_array($genre, $genresInDb, true)) {
                Genre::create([
                    'id' => Uuid::uuid4(),
                    'name' => $genre,
                ]);

                $this->addToFile($genre, 'genres.csv');
            }
        }

        foreach ($categories as $category) {
            $key = in_array($category, $categoriesInDb, true);
            if ($key === false) {
                GameCategory::create([
                    'id' => Uuid::uuid4(),
                    'name' => $category,
                ]);

                $this->addToFile($category, 'categories.csv');
            }
        }

        $gameData = [
            'id' => Uuid::uuid4(),
            'steam_appid' => $data['steam_appid'],
            'name' => $data['name'],
            'categories' => $categories,
            'genres' => $genres,
            'release_date' => $data['release_date'],
            'header_image' => $data['header_image'],
        ];

        /** @var string $gamesAsJson */
        $gamesAsJson = file_get_contents(base_path().'/database/assets/games.json');
        $gamesAsJson = substr($gamesAsJson, 0, -2);
        $gamesAsJson .= ','.json_encode($gameData, JSON_THROW_ON_ERROR).']';

        file_put_contents(
            base_path().'/database/assets/games.json',
            $gamesAsJson
        );

        return Game::create($gameData);
    }

    private function addToFile(string $data, string $file): void
    {
        file_put_contents(
            base_path().'/database/assets/'.$file,
            ','.$data,
            FILE_APPEND
        );
    }
}
