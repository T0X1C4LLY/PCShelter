<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Comment::truncate();

        $quantityOfComments = 350;

        for ($i = 0; $i < $quantityOfComments; $i++) {
            Comment::factory()->create([
                'user_id' => (User::role('creator')->inRandomOrder()->first())->id,
                'post_id' => (Post::inRandomOrder()->first())->id,
            ]);
        }
    }
}
