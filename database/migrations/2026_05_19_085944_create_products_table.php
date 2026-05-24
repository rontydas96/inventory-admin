<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Excel columns
            $table->string('material_code')->unique();      // PROD-101
            $table->string('name');
            $table->string('hsn_code')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();

            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock_level')->default(0);
            $table->decimal('rating', 3, 1)->nullable();

            $table->string('status')->default('Active');

            $table->timestamps();

            $table->index(['name']);
            $table->index(['material_code']);
            $table->index(['hsn_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};