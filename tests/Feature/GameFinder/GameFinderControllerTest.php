<?php

namespace Tests\Feature\GameFinder;

use Database\Seeders\GamesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameFinderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_paige_can_be_rendered(): void
    {
        $this->seed(GamesSeeder::class);
        $response = $this->get('/game-finder');

        $response->assertSeeInOrder(['Genre:', 'Category:', 'Type:', 'Date:']);
    }

    public function test_user_can_find_games(): void
    {
        $this->seed(GamesSeeder::class);
        $response = $this->post('/game-finder', [
            'genre' => 'all',
            'category' => 'all',
            'type' => 'general',
            'dateFrom' => null,
            'dateTo' => null,
        ]);

        $response->assertSee('Game propositions for You');
    }
}
