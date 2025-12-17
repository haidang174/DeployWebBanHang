<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_url', // LƯU public_id
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    protected $appends = ['url']; // Tự động thêm 'url' khi serialize model

    /**
     * Accessor để generate URL từ public_id
     */
    public function getUrlAttribute()
    {
        $publicId = $this->attributes['image_url'] ?? null;

        if (!$publicId) {
            return null;
        }

        try {
            return Cloudinary::getUrl($publicId, [
                'secure' => true,
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]);
        } catch (\Throwable $e) {
            // KHÔNG cho sập trang
            return null;
        }
    }
    
    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}