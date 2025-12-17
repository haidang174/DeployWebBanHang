<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_attribute_id',
        'product_name',
        'product_image',
        'size',
        'color',
        'price',
        'quantity',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    // Helper methods
    public function getVariantInfoAttribute()
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