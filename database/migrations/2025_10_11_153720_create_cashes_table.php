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
        Schema::create('cashes', function (Blueprint $table) {
            $table->id();
            $table->decimal('cash',14,2)->default(0);
            $table->decimal('today_commisoin',14,2)->default(0);
            $table->decimal('pre_day_paikar_due',14,2)->default(0);
            $table->decimal('today_amount',14,2)->default(0);
            $table->decimal('total_amanot',14,2)->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashes');
    }
};
