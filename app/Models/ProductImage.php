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
        // Kiểm tra nếu image_url đã là URL đầy đủ
        if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // Kiểm tra nếu file tồn tại trong storage/app/public
        if (Storage::disk('public')->exists($this->image_url)) {
            return Storage::disk('public')->url($this->image_url);
        }

        // Fallback: Tạo URL trực tiếp
        return asset('storage/' . $this->image_url);
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}