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
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->string('sku');
            $table->unsignedInteger('discount_id');
            $table->timestamps();

            $table->primary(['sku', 'discount_id']);

            $table->unique(['sku', 'discount_id']);

            $table->foreign('sku')->references('sku')->on('product_details');
            $table->foreign('discount_id')->references('discount_id')->on('discounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_discounts');
    }
};
