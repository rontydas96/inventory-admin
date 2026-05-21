<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('brand_name')->default('My Company');
            $table->string('logo')->nullable();

            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();

            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->decimal('default_gst_percent', 5, 2)->default(18.00);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};