<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\Http;

class FixFirst20BooksSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::take(20)->get();
        $apiKey = env('GOOGLE_BOOKS_API_KEY');

        foreach ($books as $book) {
            $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                'q' => 'isbn:' . $book->isbn,
                'key' => $apiKey
            ]);

            if ($response->successful() && isset($response->json()['items'][0])) {
                $info = $response->json()['items'][0]['volumeInfo'];
                $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null);
                
                if ($cover) {
                    $book->update(['cover_image' => $cover]);
                } else {
                    $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                        'q' => 'intitle:' . $book->title,
                        'key' => $apiKey
                    ]);
                    
                    if ($response->successful() && isset($response->json()['items'][0])) {
                        $info = $response->json()['items'][0]['volumeInfo'];
                        $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null);
                        if ($cover) {
                            $book->update(['cover_image' => $cover]);
                        }
                    }
                }
            } else {
                $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
                    'q' => 'intitle:' . $book->title,
                    'key' => $apiKey
                ]);
                
                if ($response->successful() && isset($response->json()['items'][0])) {
                    $info = $response->json()['items'][0]['volumeInfo'];
                    $cover = $info['imageLinks']['thumbnail'] ?? ($info['imageLinks']['smallThumbnail'] ?? null);
                    if ($cover) {
                        $book->update(['cover_image' => $cover]);
                    }
                }
            }
        }
    }
}
