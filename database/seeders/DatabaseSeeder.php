<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        //TODO('To jest bardzo słabe rozwiązanie, ale działa')
        $quantityOfUsers = 25;
        $quantityOfCategories = 10;
        $quantityOfPosts = 50;
        $quantityOfComments = 250;

        $usersIds = [];
        for ($i = 0; $i < $quantityOfUsers; $i++) {
            $user = User::factory()->create();
            $usersIds[] = $user->id;
        }

        $categoriesIds = [];
        for ($i = 0; $i < $quantityOfCategories; $i++) {
            $category = Category::factory()->create();
            $categoriesIds[] = $category->id;
        }

        $postsIds = [];
        for ($i = 0; $i < $quantityOfPosts; $i++) {
            $post = Post::factory()->create([
                'user_id' => $usersIds[array_rand($usersIds)],
                'category_id' => $categoriesIds[array_rand($categoriesIds)],
            ]);
            $postsIds[] = $post->id;
        }

        for ($i = 0; $i < $quantityOfComments; $i++) {
            Comment::factory()->create([
                'user_id' => $usersIds[array_rand($usersIds)],
                'post_id' => $postsIds[array_rand($postsIds)],
            ]);
        }

//        Comment::factory(150)->create();


//        $categories[] = Category::factory($quantityOfCategories)->create();
//        $users[] = User::factory($quantityOfUsers)->create();

//        Post::factory()->count(50)->create();

        //używać jeśli korzystamy inaczej niż php artisan migrate:fresh --seed
//        User::truncate();
//        Category::truncate();
//        Post::truncate();

        //Tworzy fałszywe dane ze sprecyzowanym imieniem
//        $user = user::factory()->create([
//            'name' => 'John Doe'
//        ]);



//        Post::factory(15)->create([
//            'user_id' => $user->id,
//            'category_id' => 1
//        ]);

//        try {
//            Post::factory(1)->create();
//        } catch (Exception $e) {
//
//        }

//         $personal = Category::create([
//             'name' => 'Personal',
//             'slug' => 'personal'
//         ]);
//
//        $family = Category::create([
//            'name' => 'Family',
//            'slug' => 'family'
//        ]);
//
//        $work = Category::create([
//            'name' => 'Work',
//            'slug' => 'work'
//        ]);
//
//        Post::create([
//            'user_id' => $user->id,
//            'category_id' => $family->id,
//            'title' => 'My Family Post',
//            'slug' => 'my-first-post',
//            'excerpt' => '<p>Lorem ipsum</p>',
//            'body' => '<p>lorem ipsum dolor sit amet</p>'
//        ]);
//
//        Post::create([
//            'user_id' => $user->id,
//            'category_id' => $work->id,
//            'title' => 'My Work Post',
//            'slug' => 'my-second-post',
//            'excerpt' => '<p>Lorem ipsum</p>',
//            'body' => '<p>lorem ipsum dolor sit amet</p>'
//        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
