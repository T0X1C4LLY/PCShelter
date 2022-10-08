<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use JsonException;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private array $gameArrayKeys = [
        'name',
        'steam_appid',
//        'detailed_description',
        'about_the_game',
        'short_description',
//        'supported_languages',
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

    public function index(Request $request): Factory|View|Application|RedirectResponse
    {
        if ($request->has(['search'])) {
            $isSteamId = (bool) filter_var(
                $request->input('search'),
                FILTER_VALIDATE_INT
            );

            if ($isSteamId) {
                return redirect('/games/'.$request->input('search'));
            }
        }

        $search = ['search' => $request->input('search')];

        /** @var Game[] $games */
        $games = Game::inRandomOrder()
            ->filter($search)
            ->get(['steam_appid', 'name', 'header_image'])
            ->all();

        return view('games.index', [
            'games' => $games,
        ]);
    }

    /**
     * @throws JsonException
     */
    public function show(int $steamGameId): Factory|View|Application|RedirectResponse
    {
        /** @var string $data */
        $data = file_get_contents('https://store.steampowered.com/api/appdetails?l=english&appids='.$steamGameId);
        /** @var array $dataAsArray */
        $dataAsArray = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        $dataWithoutKey = array_values($dataAsArray);
        $gameData = $dataWithoutKey[0];

        if (!$gameData['success']) {
            return back()->with('failure', 'Something went wrong');
        }

        $game = Game::where('steam_appid', '=', $steamGameId)->first();

        if (!$game) {
            $data = $gameData['data'];

            $genres = array_map(static fn (array $value) => $value['description'], $data['genres']);
            $categories = array_map(static fn (array $value) => $value['description'], $data['categories']);

            $game = Game::create([
                'id' => Uuid::uuid4(),
                'steam_appid' => $data['steam_appid'],
                'name' => $data['name'],
                'categories' => $categories,
                'genres' => $genres,
                'release_date' => $data['release_date'],
                'header_image' => $data['header_image'],
            ]);
        }

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

        /** @var Game $game */
        return view('games.show', [
            'game' => $info,
            'reviews' => $game->getBestAndGeneralReviews(),
        ]);
    }

    public function store(): void
    {
    }
}
