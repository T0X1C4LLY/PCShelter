<?php

namespace Database\Seeders;

use App\Models\GameCategory;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class GameCategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        GameCategory::truncate();

        $categories = str_getcsv(file_get_contents(base_path().'/database/assets/categories.csv'));

        foreach ($categories as $category) {
            GameCategory::create([
                'id' => Uuid::uuid4(),
                'name' => $category,
            ]);
        }
    }
}
