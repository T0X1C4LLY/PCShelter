<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class GenresSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Genre::truncate();

        $genres = str_getcsv(file_get_contents(base_path().'/database/assets/genres.csv'));

        foreach ($genres as $genre) {
           Genre::create([
               'id' => Uuid::uuid4(),
               'name' => $genre,
           ]);
        }
    }
}
