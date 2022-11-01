<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Genre;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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

    public function index(Request $request): View|Factory|Redirector|string|RedirectResponse|Application
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
        $games = Game::filter($search)
            ->orderBy('name')
            ->paginate(9);

        if ($request->ajax()) {
            $html = '';

            foreach ($games as $game) {
                $html.= '
                    <div class="px-2 py-2 transform transition duration-500 hover:scale-105">
                        <a href="/games/'.$game->steam_appid.'">
                            <img src="'.$game->header_image.'" alt="" title="'.$game->name.'" class="w-full h-full"/>
                        </a>
                    </div>
                ';
            }
            return $html;
        }

        return view('games.index');
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

        $game = Game::where('steam_appid', '=', $steamGameId)->first() ?: $this->store($gameData['data']);

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

    /**
     * @throws JsonException
     */
    public function store(array $data): Game
    {
        $genres = array_map(static fn (array $value) => $value['description'], $data['genres']);
        $categories = array_map(static fn (array $value) => $value['description'], $data['categories']);

        $genresInDb = Genre::all()->toArray();
        $categoriesInDb = GameCategory::all()->toArray();

        foreach ($genres as $genre) {
            $key = array_search($genre, array_column($genresInDb, 'name'), true);
            if (!$key) {
                Genre::create([
                    'id' => Uuid::uuid4(),
                    'name' => $genre,
                ]);

                file_put_contents(
                    base_path().'/database/assets/genres.csv',
                    $genre.',',
                    FILE_APPEND
                );
            }
        }

        foreach ($categories as $category) {
            $key = array_search($category, array_column($categoriesInDb, 'name'), true);
            if (!$key) {
                GameCategory::create([
                    'id' => Uuid::uuid4(),
                    'name' => $category,
                ]);
            }

            file_put_contents(
                base_path().'/database/assets/categories.csv',
                $category.',',
                FILE_APPEND
            );
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

        $gamesAsJson = file_get_contents(base_path().'/database/assets/games.json');
        $gamesAsJson = substr($gamesAsJson, 0, -1);
        $gamesAsJson .= ','.json_encode($gameData, JSON_THROW_ON_ERROR).']';

        file_put_contents(
            base_path().'/database/assets/games.json',
            $gamesAsJson
        );

        return Game::create($gameData);
    }
}
