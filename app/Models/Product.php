<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category_id',
        'description',
        'base_price',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderDetails()
    {
        return $this->hasManyThrough(
        OrderDetail::class,
        ProductAttribute::class,
        'product_id',             // foreign key on product_attributes
        'product_attribute_id',   // foreign key on order_details
        'id',                     // local key on products
        'id'                      // local key on product_attributes
    );
    }

    // Helper methods
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->mainImage?->image_url) {
            return Storage::url($this->mainImage->image_url);
        }

        return asset('images/default-product.jpg');
    }

    public function inStock()
    {
        return $this->attributes()->where('quantity', '>', 0)->exists();
    }

    public function getTotalStockAttribute()
    {
        return $this->attributes()->sum('quantity');
    }
}