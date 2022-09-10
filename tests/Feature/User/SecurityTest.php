<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class SecurityTest extends TestCase
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

    public function test_dashboard_screen_security_can_be_rendered_when_logged(): void
    {
        $response = $this->actingAs($this->commonUser)->get('/user/security');

        $response->assertSeeInOrder([$this->commonUser->name, 'Change name', $this->commonUser->username, 'Change username', $this->commonUser->email, 'Change email', 'New password', 'Confirm password', 'Change Password', 'Delete Account']);
        $response->assertStatus(200);
    }

    /** @dataProvider userData */
    public function test_user_data_can_be_changed(string $key, string $value): void
    {
        $response = $this->actingAs($this->commonUser)->postJson('/user/change/'.$key, [
            $key => $value,
        ]);

        $changedUser = User::where('id', $this->commonUser->id)->first();

        $response->assertStatus(302);
        $this->assertSame($value, $changedUser->$key);
    }

    private function userData(): array
    {
        return [
            ['name', 'My new Name'],
            ['username', 'user123'],
            ['email', 'user123@example.com'],
        ];
    }

    public function test_password_can_be_changed(): void
    {
        $newPassword = 'myNewPassword!1';

        $response = $this->actingAs($this->commonUser)->postJson('/user/change/password', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $changedUser = User::where('id', $this->commonUser->id)->first();

        $response->assertStatus(302);
        $this->assertTrue(Hash::check($newPassword, $changedUser->password));
    }

    public function test_account_can_be_deleted(): void
    {
        $response = $this->actingAs($this->commonUser)->post('/user/change/delete');

        $changedUser = User::where('id', $this->commonUser->id)->first();

        $response->assertStatus(302);
        $this->assertNull($changedUser);
    }
}
