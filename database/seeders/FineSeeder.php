<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fine;
use App\Models\Loan;
use Carbon\Carbon;

class FineSeeder extends Seeder
{
    public function run(): void
    {
        $overdueLoans = Loan::where('status', 'terlambat')->get();
        $count = 0;

        foreach ($overdueLoans as $loan) {
            $dueDate = Carbon::parse($loan->return_date);
            $overdueDays = (int) Carbon::now()->diffInDays($dueDate);
            
            $status = $count < 3 ? 'paid' : 'unpaid';
            $method = $status === 'paid' ? ($count % 2 === 0 ? 'Cash' : 'Transfer Bank') : null;
            $payDate = $status === 'paid' ? Carbon::now()->subDays($count) : null;

            Fine::create([
                'loan_id' => $loan->id,
                'user_id' => $loan->user_id,
                'amount' => $overdueDays * Fine::DAILY_FINE,
                'days_late' => $overdueDays,
                'payment_status' => $status,
                'payment_method' => $method,
                'payment_date' => $payDate,
            ]);

            $count++;
        }
    }
}
