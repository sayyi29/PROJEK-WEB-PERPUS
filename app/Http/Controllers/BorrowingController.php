<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Added Carbon import

class BorrowingController extends Controller
{
    /**
     * Display a listing of borrowings.
     */
    public function index()
    {
        // Update overdue statuses
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::now()->toDateString())
            ->update(['status' => 'overdue']);

        $query = Borrowing::with(['user', 'book'])->latest();

        // If member, only show their own borrowings
        if (Auth::user()->hasRole('anggota')) {
            $query->where('user_id', Auth::id());
        }

        $borrowings = $query->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new borrowing.
     */
    public function create()
    {
        // Only admin/petugas can create borrowings for any member
        // Members can create for themselves
        $books = Book::where('stock', '>', 0)->get();
        $members = User::role('anggota')->get();

        return view('borrowings.create', compact('books', 'members'));
    }

    /**
     * Store a newly created borrowing in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => Auth::user()->hasRole('anggota') ? 'nullable' : 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        $userId = Auth::user()->hasRole('anggota') ? Auth::id() : $request->user_id;

        // Check if book has stock
        $book = Book::findOrFail($request->book_id);
        if ($book->stock <= 0) {
            return back()->withErrors(['book_id' => 'Stok buku habis.']);
        }

        // Check if user has ongoing borrowing for the same book
        $existing = Borrowing::where('user_id', $userId)
            ->where('book_id', $request->book_id)
            ->where('status', 'borrowed')
            ->first();
        
        if ($existing) {
            return back()->withErrors(['book_id' => 'Anggota masih meminjam buku ini.']);
        }

        $borrowing = Borrowing::create([
            'user_id' => $userId,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'due_date' => $request->due_date,
            'status' => 'borrowed',
        ]);

        // Reduce stock
        $book->decrement('stock');

        return redirect()->route('borrowings.show', $borrowing->id)->with('success', 'Peminjaman berhasil dicatat.');
    }

    /**
     * Display the specified borrowing (Receipt view).
     */
    public function show(string $id)
    {
        $borrowing = Borrowing::with(['user', 'book', 'fine'])->findOrFail($id);
        
        // Authorization check
        if (Auth::user()->hasRole('anggota') && $borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        return view('borrowings.show', compact('borrowing'));
    }

    /**
     * Print Receipt
     */
    public function print(string $id)
    {
        $borrowing = Borrowing::with(['user', 'book'])->findOrFail($id);
        
        if (Auth::user()->hasRole('anggota') && $borrowing->user_id !== Auth::id()) {
            abort(403);
        }

        return view('borrowings.print', compact('borrowing'));
    }
}
