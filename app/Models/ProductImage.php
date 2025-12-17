<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $appends = ['url']; // Tự động thêm 'url' khi serialize model

    /**
     * Accessor để generate URL từ public_id
     */
    public function getUrlAttribute()
    {
        if (empty($this->attributes['image_url'])) {
            return null;
        }

        // Generate URL từ Cloudinary với transformations
        return cloudinary()->getUrl($this->attributes['image_url'], [
            'secure' => true,
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto'
            ]
        ]);
    }
    
    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}