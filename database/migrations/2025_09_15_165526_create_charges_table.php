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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('dailies')->onDelete('cascade');
            $table->foreignId('paikar_id')->constrained('customers')->onDelete('cascade');
            $table->decimal('total_qty', 12, 2)->default(0);
            $table->decimal('charge_per_kg', 12, 2)->default(0);
            $table->decimal('total_charge', 12, 2)->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
