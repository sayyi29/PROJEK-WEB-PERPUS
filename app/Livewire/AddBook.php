<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class AddBook extends Component
{
    public $isbn = '';
    public $title = '';
    public $author = '';
    public $publisher = '';
    public $year = '';
    public $category_id = '';
    public $stock = 1;
    public $description = '';
    public $cover_image = '';
    public $isFetching = false;

    protected $rules = [
        'title' => 'required|string',
        'author' => 'required|string',
        'isbn' => 'required|string|unique:books,isbn',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:1',
    ];

    public function fetchBookData()
    {
        if (empty($this->isbn)) return;

        $this->isFetching = true;
        
        try {
            $response = Http::timeout(10)->get("https://www.googleapis.com/books/v1/volumes", [
                'q'   => 'isbn:' . $this->isbn,
                'key' => config('services.google_books.key'),
            ]);

            if ($response->successful() && isset($response->json()['items'])) {
                $book = $response->json()['items'][0]['volumeInfo'];
                
                $this->title       = $book['title'] ?? '';
                $this->author      = implode(', ', $book['authors'] ?? []);
                $this->publisher   = $book['publisher'] ?? '';
                $this->year        = isset($book['publishedDate']) ? substr($book['publishedDate'], 0, 4) : '';
                $this->description = $book['description'] ?? '';

                // Paksa HTTPS agar tidak mixed-content error di VPS
                $cover = $book['imageLinks']['thumbnail']
                    ?? $book['imageLinks']['smallThumbnail']
                    ?? '';
                $this->cover_image = str_replace('http://', 'https://', $cover);
                
                session()->flash('success', 'Data buku ditemukan!');
            } else {
                \Log::warning('AddBook ISBN not found', [
                    'isbn'   => $this->isbn,
                    'status' => $response->status(),
                ]);
                session()->flash('error', 'Buku tidak ditemukan untuk ISBN ini.');
            }
        } catch (\Exception $e) {
            \Log::error('AddBook fetchBookData Error: ' . $e->getMessage());
            session()->flash('error', 'Gagal menghubungi API: ' . $e->getMessage());
        }

        $this->isFetching = false;
    }

    public function save()
    {
        $this->validate();

        // Handle Image Caching if it's from API
        $finalCover = null;
        if (!empty($this->cover_image) && str_starts_with($this->cover_image, 'http')) {
            try {
                $imageContent = Http::get($this->cover_image)->body();
                $filename = 'covers/' . $this->isbn . '.jpg';
                Storage::disk('public')->put($filename, $imageContent);
                $finalCover = $filename;
            } catch (\Exception $e) {
                \Log::error('Fetch cover error: ' . $e->getMessage());
            }
        }

        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'publisher' => $this->publisher,
            'year' => $this->year,
            'category_id' => $this->category_id,
            'stock' => $this->stock,
            'description' => $this->description,
            'cover_image' => $finalCover,
        ]);

        session()->flash('success', 'Buku berhasil ditambahkan ke koleksi!');
        return redirect()->route('books.index');
    }

    public function render()
    {
        return view('livewire.add-book', [
            'categories' => Category::all()
        ]);
    }
}
