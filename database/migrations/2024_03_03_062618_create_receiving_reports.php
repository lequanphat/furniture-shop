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
        Schema::create('receiving_reports', function (Blueprint $table) {
            $table->increments('receiving_report_id');
            $table->decimal('total_price', 10, 2);
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers');
            $table->foreign('created_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receiving_reports');
    }
};
