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
        Schema::table('sales', function (Blueprint $table) {
            $table->date('po_date')->nullable()->after('po_no');
            $table->string('supplier_code')->nullable()->after('po_date');
            $table->string('ref_memo_no')->nullable()->after('supplier_code');
            $table->date('sale_date')->nullable()->after('ref_memo_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'po_date',
                'supplier_code',
                'ref_memo_no',
                'sale_date',
            ]);
        });
    }
};
