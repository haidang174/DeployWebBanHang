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
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // ✅ THÊM PHẦN NÀY - Foreign key tới coupons
            $table->foreignId('coupon_id')->nullable()
                  ->constrained('coupons')->onDelete('set null');

            // Thông tin khách hàng
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address');

            // Thanh toán & tính toán
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Trạng thái & thanh toán
            $table->enum('status', [
                'pending', 'confirmed', 'processing', 'shipping', 'delivered', 'cancelled', 'refunded'
            ])->default('pending');

            $table->enum('payment_method', ['cod', 'momo'])->default('momo');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_code')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Thêm indexes
            $table->index('user_id');
            $table->index('order_code');
            $table->index('status');
            $table->index('payment_status');
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
