<?php

namespace Tests\Feature\User;

use App\Models\User;
use Database\Seeders\PermissionsAndRolesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SteamTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionsAndRolesSeeder::class);

        $this->user = User::factory()->create(['steamId' => 76561198093776072]);
        $this->user->givePermissionTo(Permission::findByName('delete_steam_data'));
    }

    public function test_page_with_steam_data_can_be_rendered(): void
    {
        $response = $this->actingAs($this->user)->get('/user/steam');

        $response->assertStatus(200);
    }

    public function test_user_can_delete_his_steam_data(): void
    {
        $response = $this->actingAs($this->user)->delete('/steam');

        $response->assertSessionHas('success', "Your steam data has been removed");
    }
}
