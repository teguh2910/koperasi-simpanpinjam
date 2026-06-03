<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'loan_type_id',
        'amount',
        'interest_rate',
        'tenure',
        'monthly_payment',
        'total_payment',
        'outstanding_balance',
        'status',
        'approved_at',
        'disbursed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'approved_at' => 'datetime',
        'disbursed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }
}