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

        Permission::create(['name' => 'create_post']);
        Permission::create(['name' => 'delete_post']);
        Permission::create(['name' => 'edit_post']);
        Permission::create(['name' => 'give_permission']);

        /** @var Model $adminRole */
        $adminRole = Role::create(['name' => 'admin']);
        /** @var Model $creatorRole */
        $creatorRole = Role::create(['name' => 'creator']);
        /** @var Model $commonUserRole */
        $commonUserRole = Role::create(['name' => 'user']);

        $adminRole->givePermissionTo([
            'create_post',
            'delete_post',
            'edit_post',
            'give_permission',
        ]);

        $creatorRole->givePermissionTo([
            'create_post',
        ]);

        $superUser->assignRole($adminRole);

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
            $user->assignRole($commonUserRole);
        }

        /** @var array<int> $creatorsIds */
        $creatorsIds = [];
        for ($i = 0; $i < $quantityOfCreators; $i++) {
            /** @var Model $user */
            $user = User::factory()->create();
            $creatorsIds[] = (int) $user->id;
            $user->assignRole($creatorRole);
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
