<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AllPostsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Post $post;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->prepareCategories();
        $this->preparePosts();
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

        $this->admin->assignRole('admin');
    }

    private function prepareCategories(): void
    {
        $this->category = Category::factory()->create();
        Category::factory()->count(2)->create();
    }

    private function preparePosts(): void
    {
        $this->post = Post::factory()->create([
            'user_id' => $this->admin->id,
            'category_id' => 1,
            'title' => 'Post ' . 1
        ]);

        for ($i = 2; $i <= 3; ++$i) {
            Post::factory()->create([
                'user_id' => $this->admin->id,
                'category_id' => $i,
                'title' => 'Post ' . $i
            ]);
        }
    }

    public function test_dashboard_screen_with_all_posts_can_not_be_rendered_while_unauthenticated(): void
    {
        $response = $this->get('/admin/posts');

        $response->assertStatus(403);
    }

    public function test_dashboard_screen_with_all_posts_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get('/admin/posts');

        $response->assertSeeInOrder(['Manage Posts', 'All Posts', 'Users', 'title', 'Comments', 'Created at']);
        $response->assertStatus(200);
    }

    public function test_edit_post_screen_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get('/admin/posts/' . $this->post->id . '/edit');

        $response->assertSeeInOrder(['Edit Post: Post 1', 'Title', 'Slug', 'Thumbnail', 'Excerpt', 'Body', 'Category', 'Update']);
        $response->assertStatus(200);
    }

    public function test_post_can_be_edited(): void
    {
        $response = $this->actingAs($this->admin)->json('PATCH', '/admin/posts/' . $this->post->id, [
            'title' => 'Updated title',
            'thumbnail' => UploadedFile::fake()->image('avatar.jpg'),
            'slug' => 'Updated slug',
            'excerpt' => 'Updated excerpt',
            'body' => 'Updated body',
            'category_id' => $this->category->id
        ]);

        $updatedPost = Post::where('id', $this->post->id)->first();

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $this->assertSame('Updated title', $updatedPost->title);
        $this->assertSame('Updated slug', $updatedPost->slug);
        $this->assertSame('Updated body', $updatedPost->body);
    }

    public function test_post_can_be_deleted(): void
    {
        $response = $this->actingAs($this->admin)->delete('/admin/posts/' . $this->post->id);

        $deletedPost = Post::where('id', $this->post->id)->first();

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        $this->assertNull($deletedPost);
    }
}
