<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Borrowing;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    use LogsActivity;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        
        $books = Book::with('category')
            ->when($categorySlug, function($query) use ($categorySlug) {
                return $query->whereHas('category', function($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->latest()
            ->paginate(15);

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    } 

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn',
            'publisher' => 'nullable|string',
            'year' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stock' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book = Book::create($validated);
        $this->logActivity('create', $book, 'Menambahkan buku baru: ' . $book->title);

        return redirect()->route('books.index')->with('success', __('messages.book_added_success'));
    }

    public function storeFromApi(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn',
            'publisher' => 'nullable|string',
            'year' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        if (!empty($validated['cover_image']) && str_starts_with($validated['cover_image'], 'http')) {
            try {
                $imageContent = Http::get($validated['cover_image'])->body();
                $filename = 'covers/' . $validated['isbn'] . '.jpg';
                \Storage::disk('public')->put($filename, $imageContent);
                $validated['cover_image'] = $filename;
            } catch (\Exception $e) {
                \Log::error('Gagal mendownload sampul buku: ' . $e->getMessage());
            }
        }

        $book = Book::create($validated);
        $this->logActivity('create', $book, 'Menambahkan buku dari API: ' . $book->title);

        return redirect()->route('books.index')->with('success', __('messages.book_added_success'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'publisher' => 'nullable|string',
            'year' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);
        return redirect()->route('books.index')->with('success', __('messages.book_updated_success'));
    }

    public function destroy(Book $book)
    {
        $this->logActivity('delete', $book, 'Menghapus buku: ' . $book->title);
        $book->delete();
        return redirect()->route('books.index')->with('success', __('messages.book_deleted_success'));
    }

    /**
     * Check availability of the book.
     */
    public function checkAvailability(Book $book)
    {
        $user = auth()->user();
        $isBorrowed = false;
        if ($user) {
            $isBorrowed = Borrowing::where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->where('status', 'borrowed')
                ->exists();
        }

        $pendingReservations = $book->reservations()->where('status', 'pending')->count();

        // Available to borrow immediately if stock > 0 and no reservations are waiting
        $isAvailable = $book->stock > 0 && $pendingReservations === 0;

        return response()->json([
            'is_available' => $isAvailable,
            'stock' => $book->stock,
            'pending_reservations' => $pendingReservations,
            'is_borrowed' => $isBorrowed,
        ]);
    }

    /**
     * Reserve a book when stock is not available.
     */
    public function reserveBook(Book $book)
    {
        $user = auth()->user();

        if (!$user->hasRole('anggota')) {
            return response()->json([
                'ok' => false,
                'message' => 'Hanya anggota yang dapat melakukan reservasi.',
            ], 403);
        }

        if ($book->stock > 0) {
            return response()->json([
                'ok' => false,
                'message' => 'Buku masih tersedia di stok, Anda dapat meminjamnya secara langsung.',
            ], 400);
        }

        $existingReservation = Reservation::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'pending')
            ->exists();

        if ($existingReservation) {
            return response()->json([
                'ok' => false,
                'message' => 'Anda sudah memiliki antrean reservasi aktif untuk buku ini.',
            ], 400);
        }

        $isBorrowed = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($isBorrowed) {
            return response()->json([
                'ok' => false,
                'message' => 'Anda sedang meminjam buku ini.',
            ], 400);
        }

        $pendingCount = $book->reservations()->where('status', 'pending')->count();
        if ($pendingCount >= 5) {
            return response()->json([
                'ok' => false,
                'message' => 'Antrean reservasi untuk buku ini sudah penuh (maksimal 5 antrean).',
            ], 400);
        }

        Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reservation_date' => now()->toDateString(),
            'status' => 'pending',
        ]);

        $this->logActivity('reserve', $book, 'Mereservasi buku: ' . $book->title);

        return response()->json([
            'ok' => true,
            'message' => __('messages.book_reservation_pending'),
        ]);
    }

    /**
     * Search books from Google Books API.
     */
    public function searchApi(Request $request)
    {
        $query = $request->query('query');
        if (empty($query)) {
            return response()->json([]);
        }

        try {
            $apiKey = env('GOOGLE_BOOKS_API_KEY');
            $response = Http::timeout(10)->get('https://www.googleapis.com/books/v1/volumes', [
                'q' => $query,
                'maxResults' => 10,
                'key' => $apiKey,
            ]);

            if ($response->successful()) {
                return response()->json($response->json()['items'] ?? []);
            }
        } catch (\Exception $e) {
            \Log::error('Search API Error: ' . $e->getMessage());
        }

        return response()->json([]);
    }
}
