<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();

        $quantityOfPosts = 150;

        for ($i = 0; $i < $quantityOfPosts; $i++) {
            Post::factory()->create([
                'user_id' => (User::role('creator')->inRandomOrder()->first())->id,
                'category_id' => (Category::inRandomOrder()->first())->id,
            ]);
        }
    }
}
