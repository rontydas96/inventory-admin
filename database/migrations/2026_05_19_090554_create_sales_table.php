<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_no')->unique();

            // Customer Details
            $table->string('customer_name');
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('customer_gst')->nullable();
            $table->string('customer_pan')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();

            // Totals
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('gst_amount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};