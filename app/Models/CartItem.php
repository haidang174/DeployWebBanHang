<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_attribute_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    // Helper methods
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function updateQuantity($quantity)
    {
        // Kiểm tra tồn kho
        if ($this->productAttribute && $quantity > $this->productAttribute->quantity) {
            return false;
        }

        $this->quantity = $quantity;
        $this->save();
        
        return true;
    }
}