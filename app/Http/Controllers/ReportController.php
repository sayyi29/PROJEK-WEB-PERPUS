<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display reports dashboard.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $totalBorrowings = Borrowing::whereBetween('borrow_date', [$startDate, $endDate])->count();
        $totalReturns = Borrowing::where('status', 'returned')
            ->whereBetween('return_date', [$startDate, $endDate])->count();
        $totalBooks = Book::count();
        $totalMembers = User::role('anggota')->count();

        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->latest()->limit(5)->get();

        return view('reports.index', compact(
            'totalBorrowings', 
            'totalReturns', 
            'totalBooks', 
            'totalMembers',
            'recentBorrowings',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Print full report.
     */
    public function print(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $borrowings = Borrowing::with(['user', 'book'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->get();

        return view('reports.print', compact('borrowings', 'startDate', 'endDate'));
    }
}
