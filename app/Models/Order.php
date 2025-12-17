<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id',
        'coupon_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'subtotal',
        'shipping_fee',
        'discount_amount',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'payment_code',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    // Helper methods
    public static function generateOrderCode()
    {
        do {
            $code = 'ORD' . strtoupper(uniqid());
        } while (self::where('order_code', $code)->exists());

        return $code;
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function updatePaymentStatus($status)
    {
        $this->payment_status = $status;
        $this->save();
    }
}