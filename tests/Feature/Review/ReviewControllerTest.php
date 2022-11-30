<?php

namespace Tests\Feature\Review;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\GamesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Game $game;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['steamId' => 76561198093776072]);
        $this->seed(GamesSeeder::class);

        $this->game = Game::where('name', 'PAYDAY 2')->first();
    }

    public function test_paige_with_game_that_user_can_review_can_be_rendered(): void
    {
        $response = $this->actingAs($this->user)->get('/add-review/'.$this->game->steam_appid.'?&name=PAYDAY+2');
        $response->assertStatus(200);
    }

    public function test_paige_with_game_that_user_cannot_review_cannot_be_rendered(): void
    {
        $response = $this->actingAs($this->user)->get('/add-review/'.$this->game->steam_appid.'?name=Counter-Strike');
        $response->assertStatus(302);
    }

    public function test_user_can_review_a_game_that_he_ows(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/add-review?name=PAYDAY+2', ['steam_appid' => $this->game->steam_appid, 'game_id' => $this->game->id]);

        $response->assertRedirect('/games/'.$this->game->steam_appid);

        $review = Review::where([['game_id', $this->game->id], ['user_id', $this->user->id]])->get();

        self::assertNotNull($review);
    }
}
