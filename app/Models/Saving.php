<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingTransactions()
    {
        return $this->hasMany(SavingTransaction::class);
    }
}