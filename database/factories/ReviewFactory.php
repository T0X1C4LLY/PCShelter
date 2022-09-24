<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'music' => $this->faker->numberBetween(0, 10),
            'graphic' => $this->faker->numberBetween(0, 10),
            'atmosphere' => $this->faker->numberBetween(0, 10),
            'difficulty' => $this->faker->numberBetween(0, 10),
            'storyline' => $this->faker->numberBetween(0, 10),
            'relaxation' => $this->faker->numberBetween(0, 10),
            'pleasure' => $this->faker->numberBetween(0, 10),
            'child-friendly' => $this->faker->numberBetween(0, 10),
            'NSFW' => $this->faker->numberBetween(0, 10),
            'gore' => $this->faker->numberBetween(0, 10),
            'unique' => $this->faker->numberBetween(0, 10),
            'general' => $this->faker->numberBetween(0, 10),
            'current_time_played' => $this->faker->randomFloat(1, 0.1, 500),
        ];
    }
}
