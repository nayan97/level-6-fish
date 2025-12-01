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
        Schema::create('auto_cash_calculations', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_cash', 15, 2)->default(0);
            $table->decimal('paikar_er_joma', 15, 2)->default(0); 
            $table->decimal('nogod_bikri_doinik_kroy', 15, 2)->default(0); 
            $table->decimal('amanot', 15, 2)->default(0);
            $table->decimal('paikar_baki', 15, 2)->default(0);
            $table->decimal('manual_ay', 15, 2)->default(0); 
            $table->decimal('uttolon', 15, 2)->default(0); 
            $table->decimal('manual_bay', 15, 2)->default(0);
            $table->decimal('cash_songjog_er_somoi_je_khoroch_add_korchi', 15, 2)->default(0);
            $table->decimal('chalan_er_payment_gula', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_cash_calculations');
    }
};
