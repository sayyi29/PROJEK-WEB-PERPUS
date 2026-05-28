<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
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
}
