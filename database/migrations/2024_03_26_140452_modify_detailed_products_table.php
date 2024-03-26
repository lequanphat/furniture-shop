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
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn('color');

            $table->unsignedInteger('color_id');

            $table->foreign('color_id')->references('color_id')->on('colors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropForeign(['color_id']);

            $table->dropColumn('color_id');

            $table->string('color');
        });
    }
};
