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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->string('size',50)->nullable();
            $table->string('color',50)->nullable();
            $table->decimal('price', 10, 2); // giá thực tế của biến thể
            $table->integer('quantity')->default(0); // tồn kho
            $table->timestamps();
            $table->unique(['product_id', 'size', 'color']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
