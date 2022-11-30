<?php

namespace Tests\Feature\Games;

use App\Models\Game;
use Database\Seeders\GamesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_paige_without_games_can_be_rendered(): void
    {
        $response = $this->get('/games');

        $response->assertSee('No more games to show.');
    }

    public function test_paige_with_all_games_can_be_rendered(): void
    {
        $this->seed(GamesSeeder::class);
        $response = $this->get('/games');

        $response->assertStatus(200);
    }

    public function test_user_can_use_search(): void
    {
        $this->seed(GamesSeeder::class);
        $response = $this->get('/games?search=call');

        $response->assertStatus(200);
    }

    public function test_paige_with_game_can_be_rendered(): void
    {
        $this->seed(GamesSeeder::class);

        $game = Game::first();

        $response = $this->get('/games/'.$game->steam_appid);

        $response->assertStatus(200);
    }
}
