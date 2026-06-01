<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    /**
     * Denda per hari Rp 1.000
     */
    const DAILY_FINE = 5000;
    const DAMAGE_PERCENT = 0.50;
    const LOST_PERCENT = 1.00;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loan_id',
        'user_id',
        'category',
        'amount',
        'days_late',
        'payment_status',
        'payment_method',
        'payment_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Get the loan associated with the fine.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get the user (borrower) associated with the fine.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
