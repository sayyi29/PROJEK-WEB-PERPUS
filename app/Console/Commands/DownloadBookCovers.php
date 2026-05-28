<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadBookCovers extends Command
{
    protected $signature = 'books:download-covers';
    protected $description = 'Download remote book covers to local storage';

    public function handle()
    {
        $books = Book::where('cover_image', 'like', 'http%')->get();
        $this->info("Menemukan {$books->count()} buku dengan sampul remote.");

        foreach ($books as $book) {
            $this->info("Mendownload sampul untuk: {$book->title}");
            try {
                $imageContent = Http::get($book->cover_image)->body();
                $filename = 'covers/' . ($book->isbn ?? $book->id) . '.jpg';
                Storage::disk('public')->put($filename, $imageContent);
                
                $book->update(['cover_image' => $filename]);
                $this->info("Berhasil disimpan: {$filename}");
            } catch (\Exception $e) {
                $this->error("Gagal mendownload {$book->title}: " . $e->getMessage());
            }
        }

        $this->info("Proses selesai.");
    }
}
