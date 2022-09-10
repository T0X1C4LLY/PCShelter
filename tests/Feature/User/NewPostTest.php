<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class NewPostTest extends TestCase
{
    use RefreshDatabase;

    private User $creator;
    private Category $category;
    private array $validNewPostData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->prepareCategories();
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


    public function test_dashboard_screen_with_create_new_post_can_be_rendered_when_creator_is_logged(): void
    {
        $response = $this->actingAs($this->creator)->get('/user/posts/create');

        $response->assertSeeInOrder(['Account', 'Posts', 'New Post', 'Comments', 'Security', 'Newsletter', 'Title', 'Slug', 'Thumbnail', 'Excerpt', 'Body', 'Category', 'Publish']);
        $response->assertStatus(200);
    }

    public function test_new_post_can_be_created_by_creator(): void
    {
        $response = $this->actingAs($this->creator)->postJson('/user/posts', $this->validNewPostData);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }
}
