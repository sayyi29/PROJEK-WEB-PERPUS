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
        // More specific search terms to get better results from public quota
        $queries = [
            'intitle:Laravel', 'intitle:PHP', 'intitle:Science', 'intitle:History', 
            'intitle:Universe', 'intitle:Design', 'intitle:Architecture', 'intitle:Philosophy',
            'intitle:Psychology', 'intitle:Business', 'intitle:Economics', 'intitle:Art'
        ];
        $count = 0;

        $this->info("Starting optimized import of $limit books...");

        foreach ($queries as $q) {
            if ($count >= $limit) break;

            $this->info("Searching for: $q...");
            
            try {
                $apiKey = env('GOOGLE_BOOKS_API_KEY');
                $response = Http::timeout(10)->get('https://www.googleapis.com/books/v1/volumes', [
                    'q' => $q,
                    'maxResults' => 40,
                    'printType' => 'books',
                    'key' => $apiKey, // Added API Key
                ]);

                if ($response->successful() && isset($response->json()['items'])) {
                    foreach ($response->json()['items'] as $item) {
                        if ($count >= $limit) break;

                        $info = $item['volumeInfo'];
                        
                        // Validate basic info
                        if (!isset($info['title']) || !isset($info['industryIdentifiers'])) continue;

                        $genre = $info['categories'][0] ?? 'General';
                        
                        $category = Category::firstOrCreate(
                            ['slug' => Str::slug($genre)],
                            ['name' => $genre, 'rack' => 'Rack-' . Str::upper(Str::random(2))]
                        );

                        $book = Book::updateOrCreate(
                            ['isbn' => $info['industryIdentifiers'][0]['identifier']],
                            [
                                'title' => $info['title'],
                                'author' => implode(', ', $info['authors'] ?? ['Unknown']),
                                'publisher' => $info['publisher'] ?? 'Unknown Publisher',
                                'year' => isset($info['publishedDate']) ? substr($info['publishedDate'], 0, 4) : date('Y'),
                                'category_id' => $category->id,
                                'description' => $info['description'] ?? 'No description available.',
                                'stock' => rand(1, 10),
                                'cover_image' => $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null),
                                'genre' => $genre,
                                'synopsis' => $info['description'] ?? 'No synopsis available.'
                            ]
                        );

                        if ($book->wasRecentlyCreated) {
                            $count++;
                            $this->line("[$count] Imported: " . Str::limit($info['title'], 40));
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error during search for $q: " . $e->getMessage());
                continue;
            }
            
            // Short sleep to avoid hitting rate limits too fast
            sleep(1);
        }

        $this->info("Successfully imported $count NEW real books.");
    }
}
