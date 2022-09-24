<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Review::truncate();

        $games = Game::all();
        $users = User::all();

        foreach ($users as $user) {
            foreach ($games as $game) {
                Review::factory()->create([
                    'game_id' => $game->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
