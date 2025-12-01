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
        Schema::create('dadon_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dadon_id')->constrained()->onDelete('cascade');
            $table->decimal('collection_amount', 14, 2); // জমার পরিমাণ
            $table->date('collection_date'); // জমার তারিখ
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
        Schema::dropIfExists('dadon_collections');
    }
};
