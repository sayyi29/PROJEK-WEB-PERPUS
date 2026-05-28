<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Http;

class FixMissingCovers extends Command
{
    protected $signature = 'books:fix-covers';
    protected $description = 'Fetch missing covers from Google Books API';

    public function handle()
    {
        $books = Book::whereNull('cover_image')->orWhere('cover_image', '')->get();
        $this->info("Found " . $books->count() . " books without covers.");

        foreach ($books as $book) {
            $this->info("Fetching cover for: {$book->title}");
            
            try {
                $apiKey = env('GOOGLE_BOOKS_API_KEY');
                $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                    'q' => 'isbn:' . $book->isbn,
                    'key' => $apiKey
                ]);

                if ($response->successful() && isset($response->json()['items'][0])) {
                    $info = $response->json()['items'][0]['volumeInfo'];
                    $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null);
                    
                    if ($cover) {
                        $book->update(['cover_image' => $cover]);
                        $this->line("Successfully updated cover for: {$book->title}");
                    } else {
                        // Try searching by title if ISBN fails
                        $this->warn("No cover found by ISBN, trying by title...");
                        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                            'q' => 'intitle:' . $book->title,
                            'key' => $apiKey
                        ]);
                        
                        if ($response->successful() && isset($response->json()['items'][0])) {
                            $info = $response->json()['items'][0]['volumeInfo'];
                            $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null);
                            if ($cover) {
                                $book->update(['cover_image' => $cover]);
                                $this->line("Successfully updated cover for: {$book->title}");
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error: " . $e->getMessage());
            }
            
            usleep(500000); // 0.5s delay
        }

        $this->info("Finished fixing covers.");
    }
}
