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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->float('total_price');
            $table->boolean('is_paid');
            $table->unsignedInteger('status');
            $table->string('receiver_name');
            $table->string('address');
            $table->string('phone_number');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('customer_id')->references('user_id')->on('users');
            $table->foreign('created_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
