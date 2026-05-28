<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportBooks extends Command
{
    protected $signature = 'books:import-google {limit=100}';
    protected $description = 'Import random books from Google Books API';

    public function handle()
    {
        $limit = $this->argument('limit');
        $genres = ['Fiction', 'Science', 'History', 'Religion', 'Technology', 'Computers', 'Philosophy', 'Art'];
        $count = 0;

        $this->info("Starting import of $limit books...");

        foreach ($genres as $genre) {
            if ($count >= $limit) break;

            $this->info("Fetching genre: $genre...");
            
            $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                'q' => 'subject:' . $genre,
                'maxResults' => 20, // Max per request
                'orderBy' => 'newest'
            ]);

            if ($response->successful() && isset($response->json()['items'])) {
                foreach ($response->json()['items'] as $item) {
                    if ($count >= $limit) break;

                    $info = $item['volumeInfo'];
                    
                    // Get or create category
                    $category = Category::firstOrCreate(
                        ['slug' => Str::slug($genre)],
                        ['name' => $genre, 'rack' => 'Rack-' . Str::upper(Str::random(2))]
                    );

                    // Insert Book
                    Book::firstOrCreate(
                        ['isbn' => $info['industryIdentifiers'][0]['identifier'] ?? Str::random(13)],
                        [
                            'title' => $info['title'],
                            'author' => implode(', ', $info['authors'] ?? ['Unknown']),
                            'publisher' => $info['publisher'] ?? 'Unknown Publisher',
                            'year' => isset($info['publishedDate']) ? substr($info['publishedDate'], 0, 4) : date('Y'),
                            'category_id' => $category->id,
                            'description' => $info['description'] ?? 'No description available.',
                            'stock' => rand(1, 10),
                            'cover_image' => $info['imageLinks']['thumbnail'] ?? null,
                            'genre' => $genre,
                            'synopsis' => $info['description'] ?? 'No synopsis available.'
                        ]
                    );

                    $count++;
                    $this->line("Imported: " . Str::limit($info['title'], 40));
                }
            }
        }

        $this->info("Successfully imported $count books.");
    }
}
