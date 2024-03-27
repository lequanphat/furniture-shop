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
        Schema::create('product_tags', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->primary(['product_id', 'tag_id']);
            $table->unique(['product_id', 'tag_id']);

            $table->foreign('tag_id')->references('tag_id')->on('tags');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tags');
    }
};
