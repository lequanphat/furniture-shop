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
        Schema::create('product_details', function (Blueprint $table) {
            $table->string('sku')->primary();
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->string('name');
            $table->string('description')->default('');
            $table->string('color');
            $table->string('size');
            $table->decimal('original_price', 10, 2);
            $table->unsignedInteger('warranty_month');
            $table->unsignedInteger('quantities');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
