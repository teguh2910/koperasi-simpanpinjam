<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SHUMember extends Model
{
    protected $table = "shu_members";

    protected $fillable = [
        "shu_period_id", "user_id", "savings_balance", "loan_interest_paid",
        "savings_percent", "loan_percent", "shu_amount",
    ];

    protected $casts = [
        "savings_balance" => "decimal:2",
        "loan_interest_paid" => "decimal:2",
        "savings_percent" => "decimal:2",
        "loan_percent" => "decimal:2",
        "shu_amount" => "decimal:2",
    ];

    public function period()
    {
        return $this->belongsTo(SHUPeriod::class, "shu_period_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
