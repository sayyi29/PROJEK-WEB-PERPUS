<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            return $this->adminDashboard($request);
        }

        return $this->memberDashboard($request);
    }

    protected function adminDashboard(Request $request)
    {
        $search = $request->input('search');

        try {
            $memberCount = User::role('anggota')->count();
        } catch (\Exception $e) {
            $memberCount = 0;
        }

        $stats = [
            'total_books' => Book::count(),
            'total_borrowed' => Borrowing::where('status', 'borrowed')->count(),
            'total_overdue' => Borrowing::where('status', 'overdue')->count(),
            'total_members' => $memberCount,
        ];

        $books = Book::with('category')->latest()->take(5)->get();

        // Chart data
        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('M');
            $data[] = Borrowing::whereMonth('borrow_date', $month->month)->whereYear('borrow_date', $month->year)->count();
        }

        $categoryStats = \App\Models\Category::withCount('books')->orderBy('books_count', 'desc')->take(5)->get();
        
        return view('dashboard', [
            'role' => 'admin',
            'stats' => $stats,
            'labels' => $labels,
            'data' => $data,
            'categoryLabels' => $categoryStats->pluck('name'),
            'categoryData' => $categoryStats->pluck('books_count'),
            'books' => $books
        ]);
    }

    protected function memberDashboard(Request $request)
    {
        $user = auth()->user();

        // Personal Stats
        $stats = [
            'borrowed' => Borrowing::where('user_id', $user->id)->where('status', 'borrowed')->count(),
            'wishlist' => \App\Models\Wishlist::where('user_id', $user->id)->count(),
            'fines' => Fine::whereHas('borrowing', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'unpaid')->sum('amount'),
            'loan_limit' => 5 - Borrowing::where('user_id', $user->id)->where('status', 'borrowed')->count(), // Example limit of 5
        ];

        // Recommendations: "For You" (based on most borrowed category)
        $favoriteCategory = Borrowing::where('user_id', $user->id)
            ->join('books', 'borrowings.book_id', '=', 'books.id')
            ->select('books.category_id', DB::raw('count(*) as total'))
            ->groupBy('books.category_id')
            ->orderBy('total', 'desc')
            ->first();

        $forYou = Book::when($favoriteCategory, function($q) use ($favoriteCategory) {
                return $q->where('category_id', $favoriteCategory->category_id);
            })
            ->withAvg('ratings', 'rating')
            ->latest()
            ->take(5)
            ->get();

        // New Arrivals
        $newArrivals = Book::latest()->take(5)->get();

        // Reading Timeline (Returned books)
        $labels = [];
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('M');
            $data[] = Borrowing::where('user_id', $user->id)
                ->where('status', 'returned')
                ->whereMonth('return_date', $month->month)
                ->whereYear('return_date', $month->year)
                ->count();
        }

        // Active Reservations
        $reservations = \App\Models\Reservation::where('user_id', $user->id)
            ->where('status', 'pending')
            ->with('book')
            ->get();

        return view('dashboard', [
            'role' => 'member',
            'stats' => $stats,
            'forYou' => $forYou,
            'newArrivals' => $newArrivals,
            'labels' => $labels,
            'data' => $data,
            'reservations' => $reservations
        ]);
    }
}
