<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\FineNotification;

class CalculateDailyFines extends Command
{
    protected $signature = 'fines:calculate';
    protected $description = 'Cek keterlambatan dan hitung denda harian otomatis';

    public function handle()
    {
        $today = Carbon::today();
        $overdueBorrowings = Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', $today)
            ->get();

        foreach ($overdueBorrowings as $borrowing) {
            $borrowing->update(['status' => 'overdue']);

            $dueDate = Carbon::parse($borrowing->due_date);
            $daysLate = $today->diffInDays($dueDate);
            $fineAmount = $daysLate * 1000;

            $fineRecord = Fine::updateOrCreate(
                ['borrowing_id' => $borrowing->id],
                [
                    'user_id' => $borrowing->user_id,
                    'amount' => $fineAmount,
                    'status' => 'unpaid'
                ]
            );

            // Kirim Email
            Mail::to($borrowing->user->email)->send(new FineNotification($fineRecord));

            $this->line("Buku: {$borrowing->book->title} | Denda: Rp " . number_format($fineAmount));
        }

        $this->info('Perhitungan denda & notifikasi selesai.');
    }
}
