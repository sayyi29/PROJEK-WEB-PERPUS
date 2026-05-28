<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    try {
        // Coba ambil dari API dengan timeout lebih lama
        $response = Http::timeout(10)->get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'trending+fiction+novels',
            'orderBy' => 'relevance',
            'maxResults' => 8,
        ]);

        if ($response->successful()) {
            $externalBooks = $response->json()['items'] ?? [];
        } else {
            $externalBooks = []; // API error
        }
    } catch (\Exception $e) {
        \Log::error('API Error: ' . $e->getMessage());
        $externalBooks = []; // Koneksi error
    }

    $latestBooks = \App\Models\Book::latest()->take(4)->get();
    
    return view('welcome', compact('latestBooks', 'externalBooks'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/books/search-api', [App\Http\Controllers\BookController::class, 'searchApi'])->name('books.search_api');

    // Data Master
    Route::post('/books/store-from-api', [App\Http\Controllers\BookController::class, 'storeFromApi'])->name('books.store_from_api');
    Route::resource('books', App\Http\Controllers\BookController::class);
    Route::get('books/{book}/check-availability', [App\Http\Controllers\BookController::class, 'checkAvailability'])->name('books.check_availability');
    Route::post('books/{book}/reserve', [App\Http\Controllers\BookController::class, 'reserveBook'])->name('books.reserve');
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('members', App\Http\Controllers\MemberController::class);
    
    // Wishlist
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::delete('/wishlist/{wishlist}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('/members/pending', [App\Http\Controllers\MemberController::class, 'pendingApproval'])->name('members.pending_approval');
    Route::post('/members/{id}/approve', [App\Http\Controllers\MemberController::class, 'approve'])->name('members.approve');
    Route::post('/members/{id}/reject', [App\Http\Controllers\MemberController::class, 'reject'])->name('members.reject');

    // Transaksi
    Route::get('/borrowings/{borrowing}/print', [App\Http\Controllers\BorrowingController::class, 'print'])->name('borrowings.print');
    Route::resource('borrowings', App\Http\Controllers\BorrowingController::class);
    
    Route::resource('returns', App\Http\Controllers\ReturnController::class);

    // Keuangan
    Route::resource('fines', App\Http\Controllers\FineController::class);

    // Laporan
    Route::get('/reports/print', [App\Http\Controllers\ReportController::class, 'print'])->name('reports.print');
    Route::get('/admin/logs', [App\Http\Controllers\LogController::class, 'index'])->name('admin.logs');
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});


require __DIR__.'/auth.php';
