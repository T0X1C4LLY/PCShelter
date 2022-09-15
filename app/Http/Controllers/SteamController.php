<?php

namespace App\Http\Controllers;

use App\Models\Steam\Library;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SteamController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): Redirector|Application|RedirectResponse
    {
        /** @var string|null $title */
        $title = request('title');

        if (!$title) {
            throw new Exception('title not found in url query');
        }

        /** @var User $user */
        $user = auth()->user();

        $userId = $user->steamId;
        $key = getenv('STEAM_API_KEY');
        $response = file_get_contents('http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key='.$key.'&include_played_free_games=1&include_appinfo=1&format=json&steamid='.$userId);

        if (!$response) {
            throw new Exception('Response from steam was empty');
        }

        /** @var array $gamesArray */
        $gamesArray = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        $library = Library::fromArray($gamesArray['response']);

        $message = $library->isInLibrary($title) ? ['success', 'You can review this game'] : ['failure', 'You can not review this game'];

        return redirect('/')->with(...$message);
    }
}
