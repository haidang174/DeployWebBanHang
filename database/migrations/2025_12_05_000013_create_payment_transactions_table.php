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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            
            // ✅ SỬA: Thêm onDelete
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            
            // ✅ THÊM: Các trường quan trọng cho Momo
            $table->string('transaction_id')->unique()->nullable(); // ID giao dịch của bạn
            $table->string('momo_trans_id')->nullable(); // Trans ID từ Momo
            $table->string('payment_method', 50)->default('momo'); // momo hoặc cod
            $table->text('momo_response')->nullable(); // Lưu full response từ Momo để debug
            $table->text('error_message')->nullable(); // Lưu lỗi nếu có
            
            $table->timestamps();
            
            // ✅ THÊM: Indexes
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
