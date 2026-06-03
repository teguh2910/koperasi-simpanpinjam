<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('max_amount', 15, 2);
            $table->decimal('min_amount', 15, 2);
            $table->integer('max_tenure');
            $table->integer('min_tenure')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_types');
    }
};