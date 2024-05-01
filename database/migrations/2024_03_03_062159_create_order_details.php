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
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedInteger('order_id');
            $table->string('sku');
            $table->unsignedInteger('quantities');
            $table->decimal('total_price', 14, 2);
            $table->timestamps();

            $table->primary(['sku', 'order_id']);
            $table->unique(['sku', 'order_id']);

            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('sku')->references('sku')->on('product_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
