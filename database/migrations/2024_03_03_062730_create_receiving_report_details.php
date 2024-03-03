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
        Schema::create('receiving_report_details', function (Blueprint $table) {
            $table->unsignedInteger('receiving_report_id');
            $table->string('sku');
            $table->unsignedInteger('quantities');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();

            $table->primary(['sku', 'receiving_report_id']);
            $table->unique(['sku', 'receiving_report_id']);

            $table->foreign('receiving_report_id')->references('receiving_report_id')->on('receiving_reports');
            $table->foreign('sku')->references('sku')->on('product_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiving_report_details');
    }
};
