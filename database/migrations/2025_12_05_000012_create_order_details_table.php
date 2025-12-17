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
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // ✅ SỬA: variant_id → product_attribute_id và product_variants → product_attributes
            $table->foreignId('product_attribute_id')
                  ->constrained('product_attributes')
                  ->onDelete('restrict');

            // Snapshot thông tin tại thời điểm đặt hàng
            $table->string('product_name');
            $table->string('product_image')->nullable();
            
            // ✅ THÊM: Lưu size/color để biết khách đã mua variant nào
            $table->string('size', 50)->nullable();
            $table->string('color', 50)->nullable();
            
            $table->decimal('price', 10, 2); 
            $table->integer('quantity');
            $table->decimal('total', 10, 2);
            $table->timestamps();
            
            // Thêm indexes
            $table->index('order_id');
            $table->index('product_attribute_id');
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
