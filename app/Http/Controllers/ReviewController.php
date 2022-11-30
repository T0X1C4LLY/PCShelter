<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ReviewController extends Controller
{
    public function create(string $steamAppid): Factory|View|Application
    {
        /** @var Game $game */
        $game = Game::where('steam_appid', $steamAppid)
            ->first(['name', 'id', 'steam_appid']);

        return view('reviews.create', [
            'game' => $game->toArray(),
        ]);
    }

    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $review = $request->except(['_token', 'name', 'steam_appid']);

        /** @var string $steamAppid */
        $steamAppid = $request->input('steam_appid');

        /** @var Game $game */
        $game = Game::where('steam_appid', $steamAppid);

        if (!$game->isReleased()) {
            return redirect(sprintf('/games/%s', $steamAppid))
                ->with(['failure' => 'Cannot review a game that was not released yet']);
        }

        /** @var User $user */
        $user = $request->user();

        $review['user_id'] = $user->id;

        Review::factory()->create($review);

        return redirect(sprintf('/games/%s', $steamAppid))
            ->with(['success' => 'Review added successfully']);
    }
}
