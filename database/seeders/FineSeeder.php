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
            $overdueDays = Carbon::now()->diffInDays($dueDate);
            
            $status = $count < 3 ? 'paid' : 'unpaid';

            Fine::create([
                'loan_id' => $loan->id,
                'amount' => $overdueDays * Fine::DAILY_FINE,
                'payment_status' => $status,
            ]);

            $count++;
        }
    }
}
