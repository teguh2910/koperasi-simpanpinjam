<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("shu_periods", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->date("period_start");
            $table->date("period_end");
            $table->decimal("total_profit", 15, 2);
            $table->decimal("member_share_percent", 5, 2)->comment("Persentase laba untuk anggota");
            $table->decimal("savings_weight", 5, 2)->default(50)->comment("Bobot simpanan (%)");
            $table->decimal("loan_weight", 5, 2)->default(50)->comment("Bobot pinjaman (%)");
            $table->decimal("total_shu", 15, 2)->default(0);
            $table->enum("status", ["draft", "completed"])->default("draft");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("shu_periods");
    }
};
