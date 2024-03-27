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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('name');
            $table->text('description')->default('');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->unsignedInteger('quantities');
            $table->unsignedInteger('brand_id');
            $table->foreign('brand_id')->references('brand_id')->on('brands');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
