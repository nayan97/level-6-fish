<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dadons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('customer')->nullable();
            $table->decimal('total_given_amount', 12, 2)->nullable();
            $table->date('given_date')->nullable();
            $table->date('due_pay_date')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['1', '0'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dadons');
    }
};
