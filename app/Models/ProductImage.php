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

    /**
     * Accessor tạo URL cho ảnh
     * Ảnh lưu trong public/storage/products/
     */
    public function getUrlAttribute()
    {
        // Nếu đã là URL đầy đủ
        if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // Database lưu: products/abc.jpg
        // Trả về: /storage/products/abc.jpg
        return asset('storage/' . $this->image_url);
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}