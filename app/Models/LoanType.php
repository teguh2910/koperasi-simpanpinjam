<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'interest_rate',
        'max_amount',
        'min_amount',
        'max_tenure',
        'min_tenure',
        'status',
    ];

    protected $casts = [
        'interest_rate' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'min_amount' => 'decimal:2',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}