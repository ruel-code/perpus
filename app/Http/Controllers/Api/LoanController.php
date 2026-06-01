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
        $query = Loan::with(['user', 'book', 'fine', 'processedBy']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $loans = $query->latest()->get();
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
                'status' => 'menunggu',
                'processed_by' => $request->processed_by ?? (auth()->check() ? auth()->id() : null),
                'condition_notes' => $request->condition_notes ?? 'Kondisi baik.',
            ]);

            $book->decrement('available_stock');

            return $this->success(new LoanResource($loan->load(['user', 'book'])), 'Loan request submitted, waiting for approval', 201);
        });
    }

    public function show(Loan $loan)
    {
        return $this->success(new LoanResource($loan->load(['user', 'book', 'fine'])), 'Loan retrieved successfully');
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'menunggu') {
            return $this->error('Loan is not in pending status', 400);
        }

        $loan->update(['status' => 'dipinjam', 'processed_by' => auth()->id()]);

        return $this->success(new LoanResource($loan->load(['user', 'book'])), 'Loan approved successfully');
    }

    public function reject(Request $request, Loan $loan)
    {
        if ($loan->status !== 'menunggu') {
            return $this->error('Loan is not in pending status', 400);
        }

        return DB::transaction(function () use ($loan) {
            $loan->book->increment('available_stock');
            $loan->update(['status' => 'ditolak']);
            return $this->success(null, 'Loan request rejected');
        });
    }

    public function cancel(Loan $loan)
    {
        $user = auth()->user();

        if ($loan->user_id !== $user->id) {
            return $this->error('You can only cancel your own loan requests', 403);
        }

        if ($loan->status !== 'menunggu') {
            return $this->error('Only pending loan requests can be cancelled', 400);
        }

        return DB::transaction(function () use ($loan) {
            $loan->book->increment('available_stock');
            $loan->update(['status' => 'ditolak']);
            return $this->success(null, 'Loan request cancelled successfully');
        });
    }

    public function update(UpdateLoanStatusRequest $request, Loan $loan)
    {
        if (in_array($loan->status, ['dikembalikan', 'ditolak'])) {
            return $this->error('Book already returned or request rejected', 400);
        }

        return DB::transaction(function () use ($request, $loan) {
            $dueDate = Carbon::parse($loan->return_date)->startOfDay();
            $actualReturnDate = $request->actual_return_date
                ? Carbon::parse($request->actual_return_date)->startOfDay()
                : now()->startOfDay();
            $book = $loan->book;

            $isLate = $actualReturnDate->gt($dueDate);
            $condition = $request->condition ?? 'baik';
            $daysLate = $isLate ? (int) $actualReturnDate->diffInDays($dueDate) : 0;

            $totalFine = 0;
            $fineCategories = [];
            $fineData = [];

            // Late fine
            if ($isLate) {
                $totalFine += $daysLate * Fine::DAILY_FINE;
                $fineCategories[] = 'terlambat';
                $fineData = [
                    'days_late' => $daysLate,
                ];
            }

            // Damage / Lost fine
            if (in_array($condition, ['rusak', 'hilang'])) {
                $bookPrice = $book->price ?? 0;
                if ($condition === 'rusak') {
                    $additionalFine = (int) ($bookPrice * Fine::DAMAGE_PERCENT);
                    $totalFine += $additionalFine;
                    $fineCategories[] = 'rusak';
                } elseif ($condition === 'hilang') {
                    $additionalFine = (int) ($bookPrice * Fine::LOST_PERCENT);
                    $totalFine += $additionalFine;
                    $fineCategories[] = 'hilang';
                }
            }

            // Determine final status
            $status = 'dikembalikan';
            if ($isLate) {
                $status = 'terlambat';
            }

            // Create fine record if any damage/lost or late
            if (!empty($fineCategories)) {
                $fineCategory = implode('+', $fineCategories);
                Fine::create([
                    'loan_id' => $loan->id,
                    'user_id' => $loan->user_id,
                    'category' => $fineCategory,
                    'amount' => $totalFine,
                    'days_late' => $daysLate,
                    'payment_status' => 'unpaid',
                ]);
            }

            // Build condition notes
            $conditionLabels = ['baik' => 'Kondisi baik', 'rusak' => 'Rusak', 'hilang' => 'Hilang'];
            $conditionLabel = $conditionLabels[$condition] ?? $condition;
            $notes = $request->condition_notes
                ? $conditionLabel . '. ' . $request->condition_notes
                : $conditionLabel . '.';

            $loan->update([
                'actual_return_date' => $actualReturnDate,
                'status' => $status,
                'condition_notes' => $notes,
            ]);

            // If lost, don't increment stock (book is gone)
            if ($condition !== 'hilang') {
                $book->increment('available_stock');
            } else {
                $book->decrement('stock');
            }

            return $this->success(new LoanResource($loan->load(['user', 'book', 'fine'])), 'Book returned successfully');
        });
    }
}
