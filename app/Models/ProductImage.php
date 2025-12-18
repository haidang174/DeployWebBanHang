<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Lấy full URL của ảnh từ Cloudinary
     */
    public function getFullUrlAttribute()
    {
        if (empty($this->image_url)) {
            return asset('images/no-image.png');
        }

        // Nếu đã là URL đầy đủ (legacy data)
        if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // Lấy cloud_name từ config
        $cloudinaryUrl = config('cloudinary.cloud_url');
        
        // Extract cloud name từ CLOUDINARY_URL
        // Format: cloudinary://api_key:api_secret@cloud_name
        preg_match('/@(.+)$/', $cloudinaryUrl, $matches);
        $cloudName = $matches[1] ?? env('CLOUDINARY_CLOUD_NAME');

        if (!$cloudName) {
            return asset('images/no-image.png');
        }

        // Build URL với transformations tối thiểu (tự động format)
        return "https://res.cloudinary.com/{$cloudName}/image/upload/f_auto,q_auto/{$this->image_url}";
    }
}