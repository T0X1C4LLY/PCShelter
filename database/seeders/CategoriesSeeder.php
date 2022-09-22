<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $quantityOfCategories = 10;

        for ($i = 0; $i < $quantityOfCategories; $i++) {
            Category::factory()->create();
        }
    }
}
