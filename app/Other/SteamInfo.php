<?php

declare(strict_types=1);

namespace App\Other;

use App\Exceptions\SteamResponseException;
use App\Models\Game;
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
        $gameData = $this->getDataFromSteam($gameId);
        $game = Game::where('steam_appid', $gameId)->first() ?: $this->addGame($gameData['data']);

        $info = $this->getSteamDataAsArray($gameData);
        $info['reviews'] = $game->getBestAndGeneralReviews();

        return $info;
    }

    /**
     * @throws \JsonException
     */
    private function addGame(array $data): Game
    {
        $genres = array_column($data['genres'], 'description');
        $categories = array_column($data['categories'], 'description');

        $gameData = [
            'id' => Uuid::uuid4(),
            'steam_appid' => $data['steam_appid'],
            'name' => $data['name'],
            'categories' => $categories,
            'genres' => $genres,
            'release_date' => $data['release_date'],
            'header_image' => $data['header_image'],
        ];

        return Game::create($gameData);
    }

    /**
     * @throws SteamResponseException
     * @throws \JsonException
     */
    private function getDataFromSteam(int $gameId): array
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

        return $gameData;
    }

    private function getSteamDataAsArray(array $gameData): array
    {
        $info = [];

        foreach ($this->gameArrayKeys as $key) {
            $info[$key] = $gameData['data'][$key] ?? null;
        }

        $info['about_the_game'] = $this->replaceSteamUrl($info['about_the_game']);
        $info['about_the_game'] = $this->deleteGameTitle($info['about_the_game']);
        $info['release_date'] = $this->setReleaseDate($info['release_date']);

        return $info;
    }

    private function replaceSteamUrl(string $text): string
    {
        /** @var string $changedText */
        $changedText =  preg_replace(
            '/("https:\/\/store.steampowered.com\/app)/',
            '"'.URL::to('/games'),
            $text
        );

        return $changedText;
    }

    private function deleteGameTitle(string $text): string
    {
        /** @var string $changedText */
        $changedText = preg_replace(
            '/(\/[a-zA-Z0-9^\w]*\/")( target="_blank")/',
            '"',
            $text
        );

        return $changedText;
    }

    private function setReleaseDate(array $date): string
    {
        return $date['coming_soon'] ? 'Coming Soon' : $date['date'];
    }
}
