<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JsonException;

class GameController extends Controller
{
    public function index(): Factory|View|Application
    {
        $games = Game::all()->all();

        $gamesAsArray = [];
        $gamesAsArray[] = array_map(/**
         * @throws JsonException
         */ static function(Game $game):array {
            $attributesToArray = $game->attributesToArray();
            $attributesToArray['categories'] = json_decode(
                $attributesToArray['categories'],
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            $attributesToArray['genres'] = json_decode(
                $attributesToArray['genres'],
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            return $attributesToArray;
        }, $games);

        return view('games.index', [
            'games' => $gamesAsArray,
        ]);
    }
}
