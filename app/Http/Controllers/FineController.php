<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    /**
     * Display a listing of fines.
     */
    public function index()
    {
        $query = Fine::with(['borrowing.user', 'borrowing.book'])->latest();

        if (Auth::user()->hasRole('anggota')) {
            $query->whereHas('borrowing', function($q) {
                $q->where('user_id', Auth::id());
            });
        }

        $fines = $query->paginate(10);
        return view('fines.index', compact('fines'));
    }

    /**
     * Update fine status (Pay fine).
     */
    public function update(Request $request, string $id)
    {
        // Only admin/petugas can mark as paid
        $fine = Fine::findOrFail($id);
        $fine->update(['status' => 'paid']);

        return back()->with('success', 'Denda berhasil dibayar.');
    }
}
