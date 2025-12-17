<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_url',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    // THÊM DÒNG NÀY: Tự động append attribute 'url' vào JSON
    protected $appends = ['url'];

    // THÊM ACCESSOR NÀY: Tạo URL đầy đủ cho ảnh
    public function getUrlAttribute()
    {
        return Storage::url($this->image_url);
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}