<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        Role::create(['name' => 'user']);

        $response = $this->post('/register', [
            'username' => 'usertest',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Str0n&P455w0r|>',
            'password_confirmation' => 'Str0n&P455w0r|>',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
