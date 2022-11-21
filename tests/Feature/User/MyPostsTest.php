<?php

namespace Tests\Feature\User;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class MyPostsTest extends TestCase
{
    use RefreshDatabase;

    private User $creator;
    private Post $creatorPost;
    private int $creatorsPosts = 3;
    private int $creatorsComments = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->preparePosts();
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

        $this->creator = User::factory()->create();
        $this->creator->assignRole('creator');
    }

    private function preparePosts(): void
    {
        for ($i = 0; $i <= $this->creatorsPosts; ++$i) {
            $this->creatorPost = Post::factory()->create([
                'user_id' => $this->creator->id,
            ]);
        }
    }

    private function prepareComments()
    {
        for ($i = 0; $i < $this->creatorsComments; ++$i) {
            Comment::factory()->create([
                'user_id' => $this->creator->id,
                'post_id' => $this->creatorPost->id,
            ]);
        }
    }

    public function test_dashboard_screen_with_my_posts_can_be_rendered_when_creator_is_logged(): void
    {
        $response = $this->actingAs($this->creator)->get('/user/posts');

        $response->assertSeeInOrder(['Title', 'Comments', 'Created at', $this->creatorPost->title, $this->creatorsComments]);
        $response->assertStatus(200);
    }
}
