<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;

class FakeBooksSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $categories = collect([
                Category::create(['name' => 'Teknologi', 'slug' => 'teknologi']),
                Category::create(['name' => 'Sains', 'slug' => 'sains']),
                Category::create(['name' => 'Sastra', 'slug' => 'sastra']),
                Category::create(['name' => 'Sejarah', 'slug' => 'sejarah']),
                Category::create(['name' => 'Agama', 'slug' => 'agama']),
            ]);
        }

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $category = $categories->random();
            Book::create([
                'isbn' => $faker->isbn13(),
                'title' => $faker->sentence(3),
                'author' => $faker->name(),
                'publisher' => $faker->company(),
                'year' => $faker->year(),
                'category_id' => $category->id,
                'description' => $faker->paragraph(),
                'stock' => rand(1, 10),
                'cover_image' => 'https://via.placeholder.com/150x200?text=Book+' . ($i + 1),
                'genre' => $category->name,
                'synopsis' => $faker->paragraph()
            ]);
        }
    }
}
