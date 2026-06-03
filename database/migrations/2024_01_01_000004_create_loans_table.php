<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->integer('tenure');
            $table->decimal('monthly_payment', 15, 2)->default(0);
            $table->decimal('total_payment', 15, 2)->default(0);
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected', 'disbursed', 'completed', 'defaulted'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};