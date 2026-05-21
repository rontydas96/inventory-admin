<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('main_category')->nullable()->after('category');
            $table->string('unit')->nullable()->after('brand');
            $table->decimal('applied_gst', 8, 2)->nullable()->after('unit');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'main_category',
                'unit',
                'applied_gst',
            ]);
        });
    }
};