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
            $table->string('po_no')->nullable()->after('customer_email');
            $table->string('challan_no')->nullable()->after('po_no');
            $table->string('vehicle_no')->nullable()->after('challan_no');
            $table->text('subject')->nullable()->after('vehicle_no');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'po_no',
                'challan_no',
                'vehicle_no',
                'subject',
            ]);
        });
    }
};
