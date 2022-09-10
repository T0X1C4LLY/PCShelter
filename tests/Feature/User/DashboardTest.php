<?php

namespace Tests\Feature\User;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DashboardTest extends TestCase
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

    private int $adminsPosts = 1;
    private int $creatorsPosts = 3;
    private int $commonUsersComments = 5;
    private int $adminsComments = 0;
    private int $creatorsComments = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(PermissionRegistrar::class)->registerPermissions();

        $this->prepareUsers();
        $this->prepareCategories();
        $this->preparePosts();
        $this->prepareComments();

        $this->validNewPostData = [
            'title' => 'Title',
            'slug' => 'Slug',
            'thumbnail' => UploadedFile::fake()->image('avatar.jpg'),
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

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->commonUser = User::factory()->create(['email' => 'user1@user.com']);
        $this->commonUser->assignRole('user');

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

        for ($i = 0; $i <= $this->adminsPosts; ++$i) {
            $this->adminPost = Post::factory()->create([
                'user_id' => $this->admin->id,
                'category_id' => $this->category->id,
            ]);
        }

        for ($i = 0; $i <= $this->creatorsPosts; ++$i) {
            $this->creatorPost = Post::factory()->create([
                'user_id' => $this->creator->id,
                'category_id' => $this->category->id,
            ]);
        }
    }

    private function prepareComments()
    {
        for ($i = 0; $i < $this->commonUsersComments; ++$i) {
            Comment::factory()->create([
                'user_id' => $this->commonUser->id,
                'post_id' => $this->post->id,
            ]);
        }

        for ($i = 0; $i < $this->adminsComments; ++$i) {
            Comment::factory()->create([
                'user_id' => $this->admin->id,
                'post_id' => $this->adminPost->id,
            ]);
        }

        for ($i = 0; $i < $this->creatorsComments; ++$i) {
            Comment::factory()->create([
                'user_id' => $this->creator->id,
                'post_id' => $this->creatorPost->id,
            ]);
        }
    }

    /** @dataProvider urlProvider */
    public function test_unauthorized_can_not_enter_dashboard(string $url): void
    {
        $response = $this->get($url);

        $response->assertRedirect('/login');
    }

    private function urlProvider(): array
    {
        return [
            ['/user/account'],
            ['/user/posts'],
            ['/user/posts/create'],
            ['/user/comments'],
            ['/user/security'],
            ['/user/newsletter'],
        ];
    }

    /** @dataProvider userProvider */
    public function test_dashboard_screen_with_my_account_data_can_be_rendered_when_user_is_logged(string $user): void
    {
        $response = $this->actingAs($this->$user)->get('/user/account');

        $comments = $user.'sComments';

        $response->assertSeeInOrder(['Username', 'Email', 'Email verified at', 'Account created at', 'Comments written', $this->$comments]);
        $response->assertStatus(200);
    }

    /** @dataProvider notForUserUrlProvider */
    public function test_dashboard_screen_with_my_posts_can_not_be_rendered_when_common_user_is_logged(string $url): void
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

    /** @dataProvider specialUserAndPostProvider */
    public function test_dashboard_screen_with_my_posts_can_be_rendered_when_not_common_user_is_logged(string $user, string $notMyPost): void
    {
        $response = $this->actingAs($this->$user)->get('/user/posts');

        $post = $user.'Post';
        $comments = $user.'sComments';

        $response->assertSeeInOrder(['Account', 'Posts', 'New Post', 'Comments', 'Security', 'Newsletter', 'Title', 'Comments', 'Created at', $this->$post->title, $this->$comments, $this->$post->createdAt]);
        $response->assertDontSee($this->$notMyPost->title);
        $response->assertStatus(200);
    }

    private function specialUserAndPostProvider(): array
    {
        return [
            ['creator', 'adminPost'],
            ['admin', 'creatorPost'],
        ];
    }

    /** @dataProvider specialUserProvider */
    public function test_dashboard_screen_with_create_new_post_can_be_rendered_when_when_not_common_user_is_logged(string $user): void
    {
        $response = $this->actingAs($this->$user)->get('/user/posts/create');

        $response->assertSeeInOrder(['Account', 'Posts', 'New Post', 'Comments', 'Security', 'Newsletter', 'Title', 'Slug', 'Thumbnail', 'Excerpt', 'Body', 'Category', 'Publish']);
        $response->assertStatus(200);
    }

    private function specialUserProvider(): array
    {
        return [
            ['creator'],
            ['admin'],
        ];
    }

    public function test_new_post_can_not_be_created_by_unauthorized_user(): void
    {
        $response = $this->postJson('/user/posts', $this->validNewPostData);

        $response->assertStatus(401);
    }

    public function test_new_post_can_not_be_created_by_common_user(): void
    {
        $response = $this->actingAs($this->commonUser)->postJson('/user/posts', $this->validNewPostData);

        $response->assertStatus(403);
    }

    /** @dataProvider specialUserProvider */
    public function test_new_post_can_be_created_by_special_user(string $user): void
    {
        $response = $this->actingAs($this->$user)->postJson('/user/posts', $this->validNewPostData);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
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

    /** @dataProvider userProvider */
    public function test_dashboard_screen_with_my_comments_can_be_rendered_when_common_user_is_logged(string $user): void
    {
        $response = $this->actingAs($this->$user)->get('/user/comments');

        $response->assertSeeInOrder(['Comment', 'Created at']);
        $response->assertStatus(200);
    }

    /** @dataProvider userProvider */
    public function test_dashboard_screen_security_can_be_rendered_when_logged(string $user): void
    {
        $response = $this->actingAs($this->$user)->get('/user/security');

        $response->assertSeeInOrder([$this->$user->name, 'Change name', $this->$user->username, 'Change username', $this->$user->email, 'Change email', 'New password', 'Confirm password', 'Change Password', 'Delete Account']);
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

    /** @dataProvider userProvider */
    public function test_password_can_be_changed(string $user): void
    {
        $newPassword = 'myNewPassword!1';

        $response = $this->actingAs($this->$user)->postJson('/user/change/password', [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $changedUser = User::where('id', $this->$user->id)->first();

        $response->assertStatus(302);
        $this->assertTrue(Hash::check($newPassword, $changedUser->password));
    }

    /** @dataProvider userProvider */
    public function test_account_can_be_deleted(string $user): void
    {
        $response = $this->actingAs($this->$user)->post('/user/change/delete');

        $changedUser = User::where('id', $this->$user->id)->first();

        $response->assertStatus(302);
        $this->assertNull($changedUser);
    }

    /** @dataProvider userProvider */
    public function test_dashboard_screen_with_newsletter_can_be_rendered_when_logged(string $user): void
    {
        $response = $this->actingAs($this->$user)->get('/user/newsletter');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['You are not a subscriber, please consider checking our newsletter', 'subscribe']);
        $response->assertDontSee(['You are currently our subscriber, Thank You for Your support', 'unsubscribe']);
    }

    private function userProvider(): array
    {
        return [
            ['commonUser'],
            ['admin'],
            ['creator'],
        ];
    }

//    public function test_newsletter_can_be_subscribed(): void
//    {
//        $response = $this->actingAs($this->commonUser)->postJson('/subscribe', [
//            'email' => $this->commonUser->email,
//        ]);
//
//        $response->assertStatus(302);
//
//        $response = $this->actingAs($this->commonUser)->get('/user/newsletter');
//        $response->assertDontSee('You are not a subscriber, please consider checking our newsletter');
//        $response->assertSeeInOrder(['You are currently our subscriber, Thank You for Your support', 'unsubscribe']);
//    }
//
//    public function test_newsletter_can_be_unsubscribed(): void
//    {
//        $response = $this->actingAs($this->commonUser)->postJson('/unsubscribe', [
//            'email' => $this->commonUser->email,
//        ]);
//
//        $response->assertStatus(302);
//
//        $response = $this->actingAs($this->commonUser)->get('/user/newsletter');
//        $response->assertSeeInOrder(['You are not a subscriber, please consider checking our newsletter', 'subscribe']);
//        $response->assertDontSee(['You are currently our subscriber, Thank You for Your support', 'unsubscribe']);
//    }
}
