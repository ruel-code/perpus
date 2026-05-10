<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'mahasiswa')->get();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) return;

        // 5 Data Dipinjam (Batas masih depan)
        for ($i = 1; $i <= 5; $i++) {
            $book = $books->random();
            if ($book->available_stock > 0) {
                Loan::create([
                    'user_id' => $users->random()->id,
                    'book_id' => $book->id,
                    'loan_code' => Loan::generateLoanCode(),
                    'loan_date' => Carbon::now()->subDays(2),
                    'return_date' => Carbon::now()->addDays(5),
                    'status' => 'dipinjam',
                ]);
                $book->decrement('available_stock');
            }
        }

        // 5 Data Dikembalikan
        for ($i = 1; $i <= 5; $i++) {
            $book = $books->random();
            Loan::create([
                'user_id' => $users->random()->id,
                'book_id' => $book->id,
                'loan_code' => Loan::generateLoanCode(),
                'loan_date' => Carbon::now()->subDays(10),
                'return_date' => Carbon::now()->subDays(3),
                'actual_return_date' => Carbon::now()->subDays(3),
                'status' => 'dikembalikan',
            ]);
            // Tidak perlu decrement stock karena sudah kembali
        }

        // 5 Data Terlambat (Batas sudah lewat)
        for ($i = 1; $i <= 5; $i++) {
            $book = $books->random();
            if ($book->available_stock > 0) {
                Loan::create([
                    'user_id' => $users->random()->id,
                    'book_id' => $book->id,
                    'loan_code' => Loan::generateLoanCode(),
                    'loan_date' => Carbon::now()->subDays(15),
                    'return_date' => Carbon::now()->subDays(5), // Batas 5 hari lalu
                    'status' => 'terlambat',
                ]);
                $book->decrement('available_stock');
            }
        }
    }
}
