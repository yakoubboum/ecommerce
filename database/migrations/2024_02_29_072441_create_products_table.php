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
            $table->id();
            
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')
                ->references('id')
                ->on('sections')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('discount')->nullable()->check('discount >= 0 AND discount <= 100');
            $table->decimal('delivery_price', 10, 2)->nullable();
            $table->string('delivery_time')->nullable();
            $table->boolean('status')->default(1);
            $table->decimal('rating', 4, 2);
            $table->integer('number_of_ratings')->nullable();
            $table->integer('number_of_sales')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('specifications', 500)->nullable();
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
