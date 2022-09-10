<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    private User $commonUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
    }

    public function prepareUsers(): void
    {
        $file = file_get_contents("/var/www/html/database/assets/rolesAndPermissions.json", );
        $rolesAndPermissions = json_decode($file, true, 512, JSON_THROW_ON_ERROR);

        $permissions = $rolesAndPermissions['permissions'];
        $roles = $rolesAndPermissions['roles'];

        array_map(static function (string $permission): void {
            Permission::create(['name' => $permission]);
        }, array_keys($permissions));

        array_map(static function (string $role) {
            Role::create(['name' => $role]);
        }, $roles);

        array_map(static function (array $roles, string $permission) {
            array_map(static function (string $role) use ($permission) {
                (Role::findByName($role))->givePermissionTo($permission);
            }, $roles);
        }, $permissions, array_keys($permissions));

        $this->commonUser = User::factory()->create(['email' => 'user1@user.com']);
        $this->commonUser->assignRole('user');
    }

    public function test_dashboard_screen_with_newsletter_can_be_rendered_when_logged(): void
    {
        $response = $this->actingAs($this->commonUser)->get('/user/newsletter');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['You are not a subscriber, please consider checking our newsletter', 'subscribe']);
        $response->assertDontSee(['You are currently our subscriber, Thank You for Your support', 'unsubscribe']);
    }
}
