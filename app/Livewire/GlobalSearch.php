<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];

    // Trigger pencarian saat variabel $query berubah
    public function updatedQuery()
    {
        if (strlen($this->query) > 2) {
            $this->search();
        } else {
            $this->results = [];
        }
    }

    // Metode eksplisit untuk ditekan Enter
    public function search()
    {
        if (empty($this->query)) return;

        try {
            $response = Http::timeout(5)->get('https://www.googleapis.com/books/v1/volumes', [
                'q' => $this->query,
                'maxResults' => 10,
            ]);

            if ($response->successful()) {
                $this->results = $response->json()['items'] ?? [];
            }
        } catch (\Exception $e) {
            \Log::error('Search Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
