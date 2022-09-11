<?php

namespace Tests\Feature\Comment;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PostCommentsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->preparePost();
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

        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    private function preparePost(): void
    {
        $this->post = Post::factory()->create();
    }


    public function test_user_can_add_a_comment_to_post(): void
    {
        $commentBody = 'This is a test comment';

        $response = $this->actingAs($this->user)->postJson('/posts/'.$this->post->slug.'/comments', [
            'body' => $commentBody,
        ]);

        $response->assertCreated();
        $response->assertSessionHas('success');

        $responseAfter = $this->get('/posts/'.$this->post->slug);

        $responseAfter->assertSee($commentBody);
    }
}
