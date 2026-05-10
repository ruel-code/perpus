<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\Fine;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanStatusRequest;
use App\Http\Resources\LoanResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoanController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Loan::with(['user', 'book', 'fine']);

        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $loans = $query->get();
        return $this->success(LoanResource::collection($loans), 'Loans retrieved successfully');
    }

    public function store(StoreLoanRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->available_stock <= 0) {
            return $this->error('Book is currently out of stock', 400);
        }

        return DB::transaction(function () use ($request, $book) {
            $loan = Loan::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'loan_date' => now(),
                'return_date' => $request->return_date,
                'status' => 'dipinjam',
            ]);

            $book->decrement('available_stock');

            return $this->success(new LoanResource($loan->load(['user', 'book'])), 'Book borrowed successfully', 201);
        });
    }

    public function show(Loan $loan)
    {
        return $this->success(new LoanResource($loan->load(['user', 'book', 'fine'])), 'Loan retrieved successfully');
    }

    public function update(UpdateLoanStatusRequest $request, Loan $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return $this->error('Book already returned', 400);
        }

        return DB::transaction(function () use ($request, $loan) {
            $actualReturnDate = $request->actual_return_date ? Carbon::parse($request->actual_return_date) : now();
            $dueDate = Carbon::parse($loan->return_date);
            
            $status = 'dikembalikan';
            
            // Check if late
            if ($actualReturnDate->gt($dueDate)) {
                $status = 'terlambat';
                $daysLate = $actualReturnDate->diffInDays($dueDate);
                
                Fine::create([
                    'loan_id' => $loan->id,
                    'amount' => $daysLate * Fine::DAILY_FINE,
                    'payment_status' => 'unpaid',
                ]);
            }

            $loan->update([
                'actual_return_date' => $actualReturnDate,
                'status' => $status,
            ]);

            $loan->book->increment('available_stock');

            return $this->success(new LoanResource($loan->load(['user', 'book', 'fine'])), 'Book returned successfully');
        });
    }
}
