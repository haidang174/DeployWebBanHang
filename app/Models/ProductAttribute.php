<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Helper methods
    public function isInStock()
    {
        return $this->quantity > 0;
    }

    public function decreaseStock($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->decrement('quantity', $quantity);
            return true;
        }
        return false;
    }

    public function increaseStock($quantity)
    {
        $this->increment('quantity', $quantity);
    }

    public function getVariantNameAttribute()
    {
        $parts = [];
        
        if ($this->size) {
            $parts[] = "Size: {$this->size}";
        }
        
        if ($this->color) {
            $parts[] = "Color: {$this->color}";
        }
        
        return implode(' | ', $parts) ?: 'Default';
    }
}