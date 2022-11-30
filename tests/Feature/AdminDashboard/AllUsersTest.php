<?php

namespace Tests\Feature\AdminDashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\CreatesApplication;
use Tests\TestCase;

class AllUsersTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    private User $admin;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
    }

    /**
     * @throws \JsonException
     */
    public function prepareUsers(): void
    {
        $file = file_get_contents(base_path()."/database/assets/rolesAndPermissions.json");
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
        $this->admin->assignRole('admin');

        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    public function test_user_can_be_deleted(): void
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

    public function test_admin_cannot_delete_itself(): void
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

    public function test_admin_can_change_user_role(): void
    {
        $this->assertTrue($this->user->hasRole('user'));
        $this->assertFalse($this->user->hasRole('creator'));

        $response = $this->actingAs($this->admin)->patch('admin/users/' . $this->user->id . '/' . Role::findByName('creator')->id);
        $response->assertStatus(302);

        $userAfter = User::where('id', $this->user->id)->first();
        $this->assertTrue($userAfter->hasRole('creator'));
        $this->assertFalse($userAfter->hasRole('user'));
    }

    public function test_admin_cannot_change_user_role_itself(): void
    {
        $this->assertTrue($this->admin->hasRole('admin'));
        $this->assertFalse($this->admin->hasRole('creator'));

        $response = $this->actingAs($this->admin)->patch('admin/users/' . $this->admin->id . '/' . Role::findByName('creator')->id);
        $response->assertStatus(302);

        $adminAfter = User::where('id', $this->admin->id)->first();
        $this->assertTrue($adminAfter->hasRole('admin'));
        $this->assertFalse($adminAfter->hasRole('creator'));
    }
}
