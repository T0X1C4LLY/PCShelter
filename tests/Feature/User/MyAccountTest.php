<?php

namespace Tests\Feature\User;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class MyAccountTest extends TestCase
{
    use RefreshDatabase;

    private User $commonUser;
    private int $commonUsersComments = 5;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->prepareComments();
    }

    public function prepareUsers(): void
    {
        $this->commonUser = User::factory()->create();
    }

    private function prepareComments()
    {
        for ($i = 0; $i < $this->commonUsersComments; ++$i) {
            Comment::factory()->create([
                'user_id' => $this->commonUser->id,
            ]);
        }
    }

    public function test_dashboard_screen_with_my_account_data_can_be_rendered_when_user_is_logged(): void
    {
        $response = $this->actingAs($this->commonUser)->get('/user/account');

        $response->assertSeeInOrder(['Username', 'Email', 'Email verified at', 'Account created at', 'Comments written', $this->commonUsersComments]);
        $response->assertStatus(200);
    }
}
