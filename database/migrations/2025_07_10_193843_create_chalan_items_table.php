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
        Schema::create('chalan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chalan_id')->constrained()->onDelete('cascade');
            $table->string('item_name');                          // মাছের নাম
            $table->decimal('quantity', 12, 2);       // কেজিতে ওজন
            $table->decimal('unit_price', 14, 2);  // প্রতি কেজি দাম
            $table->decimal('total_price', 14, 2); // মোট দাম (weight × unit_price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalan_items');
    }
};
