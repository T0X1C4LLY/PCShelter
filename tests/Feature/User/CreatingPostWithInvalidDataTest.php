<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class CreatingPostWithInvalidDataTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $commonUser;
    private User $creator;
    private Post $post;
    private Post $adminPost;
    private Post $creatorPost;
    private Category $category;
    private string $postSlug = 'unique-post-slug';
    private array $validNewPostData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->prepareCategories();
        $this->preparePosts();

        $this->validNewPostData = [
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
            'category_id' => $this->category->id,
        ];
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

    private function prepareCategories(): void
    {
        $this->category = Category::factory()->create();
    }

    private function preparePosts(): void
    {
        $this->post = Post::factory()->create([
            'slug' => $this->postSlug,
        ]);
    }


    /** @dataProvider invalidData */
    public function test_post_can_not_be_created_with_invalid_data(string $key, string $value): void
    {
        $validData = $this->validNewPostData;

        $validData[$key] = $value;

        $response = $this->actingAs($this->creator)->postJson('/user/posts', $validData);
        $response->assertStatus(422);
    }

    private function invalidData(): array
    {
        return [
            ['title', ''],
            ['slug', ''],
            ['slug', $this->postSlug],
            ['thumbnail', ''],
            ['excerpt', ''],
            ['body', ''],
            ['category_id', '-1'],
        ];
    }
}
