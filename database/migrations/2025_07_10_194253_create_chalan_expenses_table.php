<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chalan_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chalan_id')->constrained()->onDelete('cascade');
            $table->string('expense_type');                     // যেমন: বরফ, খাজনা, লেবার
            $table->decimal('amount', 14, 2);    // খরচের পরিমাণ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalan_expenses');
    }
};
