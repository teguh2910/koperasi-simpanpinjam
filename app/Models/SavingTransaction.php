<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingTransaction extends Model
{
    protected $fillable = [
        'saving_id',
        'type',
        'amount',
        'description',
        'balance_before',
        'balance_after',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    public function savingAccount()
    {
        return $this->belongsTo(Saving::class);
    }
}