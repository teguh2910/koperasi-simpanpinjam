<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("shu_members", function (Blueprint $table) {
            $table->id();
            $table->foreignId("shu_period_id")->constrained()->onDelete("cascade");
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->decimal("savings_balance", 15, 2)->default(0);
            $table->decimal("loan_interest_paid", 15, 2)->default(0);
            $table->decimal("savings_percent", 15, 2)->default(0)->comment("% kontribusi simpanan");
            $table->decimal("loan_percent", 15, 2)->default(0)->comment("% kontribusi pinjaman");
            $table->decimal("shu_amount", 15, 2)->default(0);
            $table->timestamps();

            $table->unique(["shu_period_id", "user_id"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("shu_members");
    }
};
