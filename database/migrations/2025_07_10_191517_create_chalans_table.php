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
        Schema::create('chalans', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('mohajon_id')->constrained()->onDelete('cascade');
            $table->date('chalan_date');

            $table->decimal('subtotal', 14, 2)->default(0);      // মাছের মোট দাম
            $table->decimal('discount_amount', 14, 2)->default(0);    // 5.00 (%)
            $table->decimal('discount_percent', 14, 2)->default(0);    // টাকা হিসেবে ভ্যাট
            $table->decimal('vat_amount', 14, 2)->default(0);      // ছাড়
            $table->decimal('vat_percent', 14, 2)->default(0);      // ছাড়
            $table->decimal('commission_amount', 14, 2)->default(0);
            $table->decimal('commission_percent', 14, 2)->default(0);
            $table->decimal('total_expense', 14, 2)->default(0); // বরফ, খাজনা, ভাড়া
            $table->decimal('total_amount', 14, 2)->default(0);  // Final হিসাব (subtotal + vat - discount)
            $table->decimal('payment_amount', 14, 2)->default(0);
            $table->json('return_amounts')->nullable();

            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chalans');
    }
};
