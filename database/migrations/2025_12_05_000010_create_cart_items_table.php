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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('cart_id')
                  ->constrained('carts')
                  ->onDelete('cascade');
            
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            $table->foreignId('product_attribute_id')
                  ->nullable()
                  ->constrained('product_attributes')
                  ->onDelete('cascade');
            
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // Lưu giá tại thời điểm thêm vào cart
            
            $table->timestamps();
            
            // ✅ Tránh trùng lặp: 1 cart chỉ có 1 item với cùng product_attribute
            $table->unique(['cart_id', 'product_attribute_id']);
            
            // Indexes
            $table->index('cart_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};