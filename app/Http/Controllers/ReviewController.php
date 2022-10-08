<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $steamAppid): Factory|View|Application
    {
        /** @var Game $game */
        $game = Game::where('steam_appid', '=', $steamAppid)->first(['name', 'id']);

        return view('reviews.create', ['name' => $game->name, 'id' => $game->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @throws Exception
     */
    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $review = $request->request->all();

        unset($review['_token']);

        /** @var User $user */
        $user = auth()->user();

        $review['user_id'] = $user->id;

        Review::factory()->create($review);

        /** @var Game $game */
        $game = Game::where('id', '=', $review['game_id'])->first('steam_appid');

        return redirect('/games/'.$game->steam_appid)->with(['success' => 'Review added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Review  $review
     */
    public function show(Review $review): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Review  $review
     */
    public function edit(Review $review): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Review  $review
     */
    public function update(Request $request, Review $review): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Review  $review
     */
    public function destroy(Review $review): void
    {
        //
    }
}
