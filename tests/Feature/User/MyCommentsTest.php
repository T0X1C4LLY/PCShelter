<?php

namespace Tests\Feature\User;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class MyCommentsTest extends TestCase
{
    use RefreshDatabase;

    private User $commonUser;
    private int $commonUsersComments = 5;
    private array $comments;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->prepareComments();
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

    private function prepareComments()
    {
        for ($i = 0; $i < $this->commonUsersComments; ++$i) {
            $this->comments[] = Comment::factory()->create([
                'user_id' => $this->commonUser->id,
            ]);
        }
    }

    public function test_dashboard_screen_with_my_comments_can_be_rendered_when_common_user_is_logged(): void
    {
        $response = $this->actingAs($this->commonUser)->get('/user/comments');

        $response->assertSeeInOrder(['Comment', 'Created at']);
        $response->assertSee(array_map(static fn (Comment $comment) => $comment->body, $this->comments));
        $response->assertStatus(200);
    }
}
