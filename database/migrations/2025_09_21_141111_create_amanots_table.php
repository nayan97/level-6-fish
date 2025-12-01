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
            Schema::create('amanots', function (Blueprint $table) {
                $table->id();
                $table->string('source');
                $table->decimal('amount', 14, 2);
                $table->json('return_amounts')->nullable();
                $table->date('date')->nullable();
                $table->text('note')->nullable();
                $table->enum('status', ['1', '0'])->default('1');
                $table->timestamps();
                $table->softDeletes(); // creates deleted_at column
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amanots');
    }
};
