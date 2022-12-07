<?php

namespace Tests\Feature\Newsletter;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\GamesSeeder;
use Database\Seeders\PermissionsAndRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class NewsletterControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['email' => 'tester@wp.pl']);

        $this->seed(PermissionsAndRolesSeeder::class);
    }

    public function test_user_can_subscribe_to_newsletter(): void
    {
        $response = $this->actingAs($this->user)->post('/subscribe', ['email' => $this->user->email]);

        $response->assertSessionHas('success', 'You are now signed up for our newsletter');
        self::assertTrue($this->user->hasPermissionTo(Permission::findByName('unsubscribe')));
    }

    public function test_user_can_unsubscribe_to_newsletter(): void
    {
        $response = $this->actingAs($this->user)->post('/unsubscribe', ['email' => $this->user->email]);

        $response->assertSessionHas('success', 'You are no longer subscribed for our newsletter');
        self::assertFalse($this->user->hasPermissionTo(Permission::findByName('unsubscribe')));
    }
}
