<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'transaction_id',
        'momo_trans_id',
        'payment_method',
        'momo_response',
        'error_message',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'momo_response' => 'array',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Helper methods
    public static function generateTransactionId()
    {
        do {
            $id = 'TXN' . time() . rand(1000, 9999);
        } while (self::where('transaction_id', $id)->exists());

        return $id;
    }

    public function markAsSuccess($momoTransId = null, $momoResponse = null)
    {
        $this->status = 'success';
        $this->momo_trans_id = $momoTransId;
        $this->momo_response = $momoResponse;
        $this->save();

        // Cập nhật payment_status của order
        $this->order->updatePaymentStatus('paid');
    }

    public function markAsFailed($errorMessage = null, $momoResponse = null)
    {
        $this->status = 'failed';
        $this->error_message = $errorMessage;
        $this->momo_response = $momoResponse;
        $this->save();

        // Cập nhật payment_status của order
        $this->order->updatePaymentStatus('failed');
    }
}