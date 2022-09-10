<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class NotForUserDashboardTest extends TestCase
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

    /** @dataProvider notForUserUrlProvider */
    public function test_dashboard_screen_for_creator_can_not_be_rendered_when_common_user_is_logged(string $url): void
    {
        $response = $this->actingAs($this->commonUser)->get($url);

        $response->assertStatus(403);
    }

    private function notForUserUrlProvider(): array
    {
        return [
            ['/user/posts'],
            ['/user/posts/create'],
        ];
    }

    public function test_new_post_can_not_be_created_by_common_user(): void
    {
        $response = $this->actingAs($this->commonUser)->postJson('/user/posts', [
            'title' => 'Title',
            'slug' => 'Slug',
            'thumbnail' => new UploadedFile(
                public_path('storage/public/logo.png'),
                'logo.png',
                null,
                null,
                true
            ),
            'excerpt' => 'Excerpt',
            'body' => 'Body',
            'category_id' => 1,
        ]);

        $response->assertStatus(403);
    }
}
