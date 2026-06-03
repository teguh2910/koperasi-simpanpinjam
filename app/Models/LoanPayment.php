<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    protected $fillable = [
        'loan_id',
        'amount',
        'principal',
        'interest',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'principal' => 'decimal:2',
        'interest' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}