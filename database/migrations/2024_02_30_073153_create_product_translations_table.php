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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale')->index();

            // Foreign key to the main model
            $table->unsignedBigInteger('product_id');
            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // fields you want to translate
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
