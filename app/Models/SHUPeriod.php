<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SHUPeriod extends Model
{
    protected $table = "shu_periods";

    protected $fillable = [
        "name", "period_start", "period_end", "total_profit",
        "member_share_percent", "savings_weight", "loan_weight",
        "total_shu", "status",
    ];

    protected $casts = [
        "period_start" => "date",
        "period_end" => "date",
        "total_profit" => "decimal:2",
        "member_share_percent" => "decimal:2",
        "savings_weight" => "decimal:2",
        "loan_weight" => "decimal:2",
        "total_shu" => "decimal:2",
    ];

    public function members()
    {
        return $this->hasMany(SHUMember::class, "shu_period_id");
    }
}
