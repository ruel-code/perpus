<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_code',
        'loan_date',
        'return_date',
        'actual_return_date',
        'status',
        'processed_by',
        'condition_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($loan) {
            if (empty($loan->loan_code)) {
                $loan->loan_code = static::generateLoanCode();
            }
        });
    }

    /**
     * Generate a unique loan code.
     * Format: LIB-YYYYMMDD-001
     *
     * @return string
     */
    public static function generateLoanCode()
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = "LIB-{$date}-";
        
        $lastLoan = static::where('loan_code', 'like', "{$prefix}%")
            ->orderBy('loan_code', 'desc')
            ->first();

        if ($lastLoan) {
            $lastSequence = (int) substr($lastLoan->loan_code, -3);
            $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '001';
        }

        return $prefix . $newSequence;
    }

    /**
     * Get the user that made the loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the staff member who processed the loan.
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get the book that was loaned.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the fine associated with the loan.
     */
    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}
