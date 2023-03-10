<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var array<string> $excerpt */
        $excerpt = $this->faker->paragraphs(2);

        /** @var array<string> $body */
        $body = $this->faker->paragraphs(6);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'excerpt' => '<p>' . implode('</p><p>', $excerpt) . '</p>',
            'body' => '<p>' . implode('</p><p>', $body) . '</p>',
        ];
    }
}
