<?php

namespace App\Http\Middleware;

use App\Models\Game;
use App\Models\User;
use App\Steam\Library;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JsonException;

class OwnTheGame
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     * @throws JsonException
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        /** @var string|null $name */
        $name = $request->input('name');

        if (!$name) {
            throw new Exception('title not found in url query');
        }

        /** @var User $user */
        $user = $request->user();
        $userId = $user->steamId;

        if (!$userId) {
            return back()->with(['failure' => 'You must login to Your Steam Account to review a game']);
        }

        $library = $this->getUserLibrary($userId);

        if (!$library->isInLibrary($name)) {
            return back()->with(['failure' => 'You cannot review a game that You do not own']);
        }

        $game = $library->getByName($name);

        if (!$game->wasEverPlayed()) {
            return back()->with(['failure' => 'You can only review a game that You played at least 1 hour']);
        }

        /** @var Game $gameInDb */
        $gameInDb = Game::where('name', $request->input('name'))
            ->first(['name', 'id']);

        /** @var string $userUuid */
        $userUuid = $user->getAuthIdentifier();

        if ($gameInDb->wasReviewedBy($userUuid)) {
            return back()->with(['failure' => 'You can only review a game once']);
        }

        $request->request->add(['current_time_played' => $game->playtimeForever]);

        return $next($request);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    private function getUserLibrary(int $userId): Library
    {
        $key = getenv('STEAM_USER_GAMES_URL');

        $response = file_get_contents($key.$userId);

        if (!$response) {
            throw new Exception('Response from steam was empty');
        }

        /** @var array $gamesArray */
        $gamesArray = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        return Library::fromArray($gamesArray['response']);
    }
}
