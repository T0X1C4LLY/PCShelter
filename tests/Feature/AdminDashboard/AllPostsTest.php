<?php

namespace Tests\Feature\AdminDashboard;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\CreatesApplication;
use Tests\TestCase;

class AllPostsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    private User $admin;
    private Post $post;
    private Category $category;
    private array $posts;
    private int $amountOfPosts = 3;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
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

    private function preparePosts(): void
    {
        $this->post = Post::factory()->create();

        for ($i = 1; $i < $this->amountOfPosts; ++$i) {
            $this->posts[] = Post::factory()->create();
        }
    }

    private function prepareCategories(): void
    {
        $this->category = Category::factory()->create();
    }

    public function test_dashboard_screen_with_all_posts_can_be_rendered()
    {
        $this->preparePosts();

        $response = $this->actingAs($this->admin)->get('/admin/posts');

        $response->assertSeeInOrder(['Manage Posts', 'All Posts', 'Users', 'title', 'Comments', 'Created at']);
        $response->assertSee(array_map(static fn (Post $post) => $post->title, $this->posts), $this->post->title);
        $response->assertStatus(200);
    }

    public function test_edit_post_screen_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get('/admin/posts/' . $this->post->id . '/edit');

        $response->assertSeeInOrder(['Edit Post: '.$this->post->title, 'Title', 'Slug', 'Thumbnail', 'Excerpt', 'Body', 'Category', 'Update']);
        $response->assertStatus(200);
    }

    public function test_post_can_be_edited(): void
    {
        $this->prepareCategories();

        $response = $this->actingAs($this->admin)->json('PATCH', '/user/posts/' . $this->post->id, [
            'title' => 'Updated title',
            'thumbnail' => new UploadedFile(
                public_path('storage/public/logo.png'),
                'logo.png',
                null,
                null,
                true
            ),
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

        Storage::delete($updatedPost->thumbnail);
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
