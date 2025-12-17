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
        'cloudinary_public_id',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * Accessor để lấy URL ảnh
     * Tự động detect Cloudinary hay local storage
     */
    public function getUrlAttribute()
    {
        // Nếu là Cloudinary URL (chứa cloudinary.com)
        if (str_contains($this->image_url, 'cloudinary.com')) {
            return $this->image_url;
        }
        
        // Nếu là local storage
        return Storage::url($this->image_url);
    }

    /**
     * Kiểm tra xem ảnh có phải từ Cloudinary không
     */
    public function isCloudinary()
    {
        return !empty($this->cloudinary_public_id) || str_contains($this->image_url, 'cloudinary.com');
    }

    /**
     * Lấy URL ảnh với transformation từ Cloudinary
     * 
     * @param int|null $width Width của ảnh
     * @param int|null $height Height của ảnh
     * @param string $crop Crop mode (fill, fit, scale, pad, etc.)
     * @param array $options Các options khác như quality, format, effect
     * @return string
     */
    public function getTransformedUrl($width = null, $height = null, $crop = 'fill', $options = [])
    {
        // Nếu không phải Cloudinary URL, return URL gốc
        if (!$this->isCloudinary()) {
            return $this->url;
        }

        // Build transformation array
        $transformations = [];
        
        if ($width) {
            $transformations[] = "w_$width";
        }
        
        if ($height) {
            $transformations[] = "h_$height";
        }
        
        if ($width || $height) {
            $transformations[] = "c_$crop";
        }
        
        // Add quality (mặc định auto)
        $quality = $options['quality'] ?? 'auto';
        $transformations[] = "q_$quality";
        
        // Add format (mặc định auto)
        $format = $options['format'] ?? 'auto';
        $transformations[] = "f_$format";
        
        // Add effects nếu có
        if (isset($options['effect'])) {
            $transformations[] = "e_{$options['effect']}";
        }
        
        // Add blur nếu có (cho lazy loading)
        if (isset($options['blur'])) {
            $transformations[] = "e_blur:{$options['blur']}";
        }
        
        $transformationString = implode(',', $transformations);
        
        // Replace /upload/ với /upload/{transformation}/
        return str_replace('/upload/', "/upload/$transformationString/", $this->image_url);
    }

    /**
     * Lấy thumbnail (ảnh vuông nhỏ)
     * 
     * @param int $size Kích thước vuông (default: 200px)
     * @return string
     */
    public function getThumbnailUrl($size = 200)
    {
        return $this->getTransformedUrl($size, $size, 'fill');
    }

    /**
     * Lấy URL ảnh responsive với width cụ thể
     * Giữ tỷ lệ gốc
     * 
     * @param int $width
     * @return string
     */
    public function getResponsiveUrl($width)
    {
        return $this->getTransformedUrl($width, null, 'scale');
    }

    /**
     * Lấy URL ảnh cho lazy loading (blur placeholder)
     * 
     * @param int $width Kích thước nhỏ cho placeholder
     * @return string
     */
    public function getPlaceholderUrl($width = 50)
    {
        return $this->getTransformedUrl($width, null, 'scale', [
            'quality' => 1,
            'blur' => 1000
        ]);
    }

    /**
     * Lấy srcset cho responsive images
     * 
     * @param array $widths Mảng các width cần tạo (vd: [400, 800, 1200])
     * @return string
     */
    public function getSrcset($widths = [400, 800, 1200, 1600])
    {
        if (!$this->isCloudinary()) {
            return $this->url;
        }

        $srcset = [];
        foreach ($widths as $width) {
            $url = $this->getResponsiveUrl($width);
            $srcset[] = "$url {$width}w";
        }
        
        return implode(', ', $srcset);
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}