<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'gst_percentage')) {
                $table->decimal('gst_percentage', 8, 2)->nullable()->after('applied_gst');
            }

            if (!Schema::hasColumn('products', 'selling_price')) {
                $table->decimal('selling_price', 12, 2)->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'gst_percentage')) {
                $table->dropColumn('gst_percentage');
            }

            if (Schema::hasColumn('products', 'selling_price')) {
                $table->dropColumn('selling_price');
            }
        });
    }
};
