<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \JsonException
     */
    public function run()
    {
        //TODO('zawartość będzie trzeba wyodrębnić do poszczególnych klas seedera')
//        $this->call(KlasaSeedera::class);

        User::truncate();
        Category::truncate();
        Post::truncate();
        Comment::truncate();
        Permission::truncate();
        Role::truncate();

        /** @var Model $superUser */
        $superUser = User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@admin.com',
        ]);

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

        $superUser->assignRole(Role::findByName('admin'));

        $quantityOfCommonUsers = 34;
        $quantityOfCreators = 15;
        $quantityOfCategories = 10;
        $quantityOfPosts = 150;
        $quantityOfComments = 350;

        /** @var array<int> $commonUsersIds */
        $commonUsersIds = [];
        for ($i = 0; $i < $quantityOfCommonUsers; $i++) {
            /** @var Model $user */
            $user = User::factory()->create();
            $commonUsersIds[] = (int) $user->id;
            $user->assignRole(Role::findByName('user'));
        }

        /** @var array<int> $creatorsIds */
        $creatorsIds = [];
        for ($i = 0; $i < $quantityOfCreators; $i++) {
            /** @var Model $user */
            $user = User::factory()->create();
            $creatorsIds[] = (int) $user->id;
            $user->assignRole(Role::findByName('creator'));
        }
        /** @var array<int> $categoriesIds */
        $categoriesIds = [];
        for ($i = 0; $i < $quantityOfCategories; $i++) {
            /** @var Model $category */
            $category = Category::factory()->create();
            $categoriesIds[] = (int) $category->id;
        }

        /** @var array<int> $postsIds */
        $postsIds = [];
        for ($i = 0; $i < $quantityOfPosts; $i++) {
            /** @var Model $post */
            $post = Post::factory()->create([
                'user_id' => $creatorsIds[array_rand($creatorsIds)],
                'category_id' => $categoriesIds[array_rand($categoriesIds)],
            ]);
            $postsIds[] = (int) $post->id;
        }

        for ($i = 0; $i < $quantityOfComments; $i++) {
            Comment::factory()->create([
                'user_id' => $commonUsersIds[array_rand($commonUsersIds)],
                'post_id' => $postsIds[array_rand($postsIds)],
            ]);
        }
    }
}
