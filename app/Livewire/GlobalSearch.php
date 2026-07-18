<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Book;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];

    /** Trigger saat $query berubah (debounce dilakukan di view) */
    public function updatedQuery()
    {
        if (strlen($this->query) > 2) {
            $this->search();
        } else {
            $this->results = [];
        }
    }

    /** Cari buku: DB lokal + Google Books API */
    public function search()
    {
        if (empty($this->query)) return;

        // ① Cari di database lokal terlebih dahulu
        $localBooks = Book::where('title', 'like', '%' . $this->query . '%')
            ->orWhere('author', 'like', '%' . $this->query . '%')
            ->take(5)
            ->get()
            ->map(fn($b) => [
                'source' => 'local',
                'id'     => $b->id,
                'volumeInfo' => [
                    'title'      => $b->title,
                    'authors'    => [$b->author],
                    'imageLinks' => ['thumbnail' => $b->cover_image_url],
                ],
            ])
            ->toArray();

        // ② Cari di Google Books API (dengan key agar tidak kena rate-limit)
        $apiResults = [];
        try {
            $response = Http::timeout(8)->get('https://www.googleapis.com/books/v1/volumes', [
                'q'          => $this->query,
                'maxResults' => 8,
                'key'        => config('services.google_books.key'),
            ]);

            if ($response->successful()) {
                $apiResults = array_map(function ($item) {
                    $item['source'] = 'google';
                    return $item;
                }, $response->json()['items'] ?? []);
            }
        } catch (\Exception $e) {
            \Log::error('GlobalSearch API Error: ' . $e->getMessage());
        }

        // Gabungkan: lokal di atas, Google di bawah
        $this->results = array_merge($localBooks, $apiResults);
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
