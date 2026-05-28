<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'ahmad@gmail.com')->first();
        $books = Book::take(2)->get();

        if ($user && $books->count() > 0) {
            foreach ($books as $book) {
                Reservation::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'reservation_date' => now(),
                    'status' => 'pending'
                ]);
            }
        }
    }
}
