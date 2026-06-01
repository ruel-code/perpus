<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Fine;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use ApiResponse;

    public function stats()
    {
        $totalBooks = Book::count();
        $totalAvailable = Book::sum('available_stock');
        $totalMembers = User::where('role', 'user')->count();
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $activeLoans = Loan::whereIn('status', ['dipinjam', 'terlambat'])->count();
        $totalReturns = Loan::where('status', 'dikembalikan')->count();
        $totalFines = Fine::where('payment_status', 'unpaid')->sum('amount');
        $pendingLoans = Loan::where('status', 'menunggu')->count();

        return $this->success([
            'total_books' => $totalBooks,
            'total_available' => $totalAvailable,
            'total_members' => $totalMembers,
            'admin_count' => $adminCount,
            'user_count' => $userCount,
            'active_loans' => $activeLoans,
            'total_returns' => $totalReturns,
            'total_fines' => (float) $totalFines,
            'pending_loans' => $pendingLoans,
        ], 'Dashboard stats retrieved successfully');
    }

    public function chartData()
    {
        $months = collect();
        $loansData = collect();
        $returnsData = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('Y-m');
            $label = $date->format('M Y');

            $months->push($label);
            $loansData->push(Loan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count());
            $returnsData->push(Loan::where('status', 'dikembalikan')
                ->whereYear('actual_return_date', $date->year)
                ->whereMonth('actual_return_date', $date->month)
                ->count());
        }

        return $this->success([
            'months' => $months,
            'loans' => $loansData,
            'returns' => $returnsData,
        ], 'Chart data retrieved successfully');
    }
}
