<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\Reservation; // Make sure Reservation model is imported if not globally available
use App\Notifications\BookAvailableNotification; // Import the notification
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification; // Import Notification facade if sending via other channels besides direct user model

class ReturnController extends Controller
{
    /**
     * Display a listing of returns.
     */
    public function index()
    {
        $query = Borrowing::with(['user', 'book'])->where('status', 'returned')->latest();

        if (Auth::user()->hasRole('anggota')) {
            $query->where('user_id', Auth::id());
        }

        $returns = $query->paginate(10);
        return view('returns.index', compact('returns'));
    }

    /**
     * Show return form.
     */
    public function create()
    {
        // Only admin/petugas can process returns
        $borrowings = Borrowing::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->get();
        
        return view('returns.create', compact('borrowings'));
    }

    /**
     * Process return.
     */
    public function store(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
            'return_date' => 'required|date',
        ]);

        $borrowing = Borrowing::findOrFail($request->borrowing_id);
        
        if ($borrowing->status === 'returned') {
            return back()->withErrors(['borrowing_id' => __('messages.book_already_returned')]);
        }

        $returnDate = Carbon::parse($request->return_date);
        $dueDate = Carbon::parse($borrowing->due_date);
        
        // Update borrowing status and return date
        $borrowing->update([
            'return_date' => $returnDate,
            'status' => 'returned',
        ]);

        // Increase book stock
        $borrowing->book->increment('stock');

        $fineAmount = 0; // Initialize fine amount
        $successMessage = __('messages.book_returned_on_time');

        // Fine calculation if overdue
        if ($returnDate->gt($dueDate)) {
            $daysOverdue = $returnDate->diffInDays($dueDate);
            $fineAmount = $daysOverdue * 1000; // Adjust fine rate as needed

            Fine::create([
                'borrowing_id' => $borrowing->id,
                'amount' => $fineAmount,
                'status' => 'unpaid',
            ]);
            $successMessage = __('messages.book_returned_with_fine') . number_format($fineAmount, 0, ',', '.');
        }

        // Check for pending reservations after returning the book
        $pendingReservation = $borrowing->book->reservations()
            ->where('status', 'pending')
            ->orderBy('reservation_date', 'asc')
            ->first();

        if ($pendingReservation) {
            // Notify the user that the book is available
            $pendingReservation->user->notify(new \App\Notifications\BookAvailableNotification($pendingReservation->user, $borrowing->book));

            // Update the reservation status
            $pendingReservation->update([
                'status' => 'available',
                'available_from_date' => Carbon::now()->toDateString(),
            ]);
            
            // Append reservation info to success message
            $reservationMsg = ' ' . __('messages.reservation_activated', ['name' => $pendingReservation->user->name]);
            $successMessage .= $reservationMsg;
        }

        return redirect()->route('returns.index')->with('success', $successMessage);
    }
}
