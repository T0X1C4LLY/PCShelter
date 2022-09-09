<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AllUsersTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;

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

        $this->admin = User::factory()->create();
        $this->user = User::factory()->create();

        $this->admin->assignRole('admin');
        $this->user->assignRole('user');
    }

    public function test_dashboard_screen_with_all_users_can_not_be_rendered_while_unauthenticated(): void
    {
        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_dashboard_screen_with_all_users_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');

        $response->assertSeeInOrder([
            'Manage Posts',
            'All Posts',
            'Users',
            'Username',
            'Name',
            'Created at',
            'Role',
            $this->admin->username
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_be_deleted()
    {
        $responseBefore = $this->actingAs($this->admin)->get('/admin/users');
        $responseBefore->assertSee($this->user->username);

        $response = $this->delete('admin/users/' . $this->user->id);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $responseAfter = $this->actingAs($this->admin)->get('/admin/users');
        $responseAfter->assertDontSee($this->user->username);

        $userAfter = User::where('id', $this->user->id)->first();
        $this->assertNull($userAfter);
    }

    public function test_admin_can_not_delete_itself()
    {
        $responseBefore = $this->actingAs($this->admin)->get('/admin/users');
        $responseBefore->assertSee($this->admin->username);

        $response = $this->delete('admin/users/' . $this->admin->id);
        $response->assertSessionHas('failure');

        $responseAfter = $this->actingAs($this->admin)->get('/admin/users');
        $responseAfter->assertSee($this->admin->username);

        $adminAfter = User::where('id', $this->admin->id)->first();

        $this->assertNotNull($adminAfter);
    }

    //może sprawdzać te modele przy każdym teście tak żeby robić na to podwójne asercje
    public function test_admin_can_change_user_role()
    {
        $this->assertTrue($this->user->hasRole('user'));
        $this->assertFalse($this->user->hasRole('creator'));

        $response = $this->actingAs($this->admin)->patch('admin/users/' . $this->user->id . '/' . Role::findByName('creator')->id);
        $response->assertStatus(302);

        $userAfter = User::where('id', $this->user->id)->first();
        $this->assertTrue($userAfter->hasRole('creator'));
        $this->assertFalse($userAfter->hasRole('user'));
    }
}
