<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('purchases', 'product_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropColumn('product_id');
            });
        }
    }

    public function down()
    {
        if (!Schema::hasColumn('purchases', 'product_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->unsignedBigInteger('product_id')->nullable()->after('id');
                $table->index('product_id', 'purchases_product_id_foreign');
            });
        }
    }
};
