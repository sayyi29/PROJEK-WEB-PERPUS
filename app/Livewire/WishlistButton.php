<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $bookId;
    public $isWishlisted = false;

    public function mount($bookId)
    {
        $this->bookId = $bookId;
        if (Auth::check()) {
            $this->isWishlisted = Wishlist::where('user_id', Auth::id())->where('book_id', $this->bookId)->exists();
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isWishlisted) {
            Wishlist::where('user_id', Auth::id())->where('book_id', $this->bookId)->delete();
            $this->isWishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'book_id' => $this->bookId,
            ]);
            $this->isWishlisted = true;
        }
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
