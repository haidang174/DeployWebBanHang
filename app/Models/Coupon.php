<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_per_user',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper methods
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();
        
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if ($subtotal < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            
            if ($this->max_discount_amount) {
                $discount = min($discount, $this->max_discount_amount);
            }
            
            return $discount;
        }

        // Fixed discount
        return min($this->value, $subtotal);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}