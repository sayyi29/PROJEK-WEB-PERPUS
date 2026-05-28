<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookRating extends Component
{
    public $bookId;
    public $rating = 0;
    public $review = '';
    public $hasRated = false;

    public function mount($bookId)
    {
        $this->bookId = $bookId;
        $existing = Rating::where('user_id', Auth::id())->where('book_id', $this->bookId)->first();
        if ($existing) {
            $this->rating = $existing->rating;
            $this->review = $existing->review;
            $this->hasRated = true;
        }
    }

    public function setRating($value)
    {
        if ($this->hasRated) return;
        $this->rating = $value;
    }

    public function submit()
    {
        if ($this->hasRated) return;

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        Rating::create([
            'user_id' => Auth::id(),
            'book_id' => $this->bookId,
            'rating' => $this->rating,
            'review' => $this->review,
        ]);

        $this->hasRated = true;
        
        session()->flash('success', 'Terima kasih atas ulasan Anda!');
    }

    public function render()
    {
        $book = Book::with('ratings.user')->find($this->bookId);
        return view('livewire.book-rating', [
            'book' => $book
        ]);
    }
}
