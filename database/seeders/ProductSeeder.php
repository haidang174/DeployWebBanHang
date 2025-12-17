<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            // Áo Nam
            [
                'name' => 'Áo Thun Nam Basic',
                'category_id' => 1,
                'description' => 'Áo thun nam chất liệu cotton 100%, co giãn tốt, thoáng mát',
                'base_price' => 150000,
                'images' => [
                    'https://via.placeholder.com/600x600/3498db/ffffff?text=Ao+Thun+Nam+1',
                    'https://via.placeholder.com/600x600/2980b9/ffffff?text=Ao+Thun+Nam+2',
                ],
                'attributes' => [
                    ['size' => 'S', 'color' => 'Đen', 'price' => 150000, 'quantity' => 50],
                    ['size' => 'M', 'color' => 'Đen', 'price' => 150000, 'quantity' => 100],
                    ['size' => 'L', 'color' => 'Đen', 'price' => 150000, 'quantity' => 80],
                    ['size' => 'S', 'color' => 'Trắng', 'price' => 150000, 'quantity' => 40],
                    ['size' => 'M', 'color' => 'Trắng', 'price' => 150000, 'quantity' => 90],
                    ['size' => 'L', 'color' => 'Trắng', 'price' => 150000, 'quantity' => 70],
                ],
            ],
            [
                'name' => 'Áo Sơ Mi Nam Dài Tay',
                'category_id' => 1,
                'description' => 'Áo sơ mi nam công sở, form chuẩn, dễ phối đồ',
                'base_price' => 250000,
                'images' => [
                    'https://via.placeholder.com/600x600/e74c3c/ffffff?text=Ao+So+Mi+1',
                    'https://via.placeholder.com/600x600/c0392b/ffffff?text=Ao+So+Mi+2',
                ],
                'attributes' => [
                    ['size' => 'M', 'color' => 'Xanh Navy', 'price' => 250000, 'quantity' => 60],
                    ['size' => 'L', 'color' => 'Xanh Navy', 'price' => 250000, 'quantity' => 80],
                    ['size' => 'XL', 'color' => 'Xanh Navy', 'price' => 250000, 'quantity' => 50],
                    ['size' => 'M', 'color' => 'Trắng', 'price' => 250000, 'quantity' => 70],
                    ['size' => 'L', 'color' => 'Trắng', 'price' => 250000, 'quantity' => 90],
                ],
            ],

            // Áo Nữ
            [
                'name' => 'Áo Kiểu Nữ Hoa Nhí',
                'category_id' => 2,
                'description' => 'Áo kiểu nữ họa tiết hoa nhí dễ thương, phong cách Hàn Quốc',
                'base_price' => 180000,
                'images' => [
                    'https://via.placeholder.com/600x600/f39c12/ffffff?text=Ao+Kieu+Nu+1',
                    'https://via.placeholder.com/600x600/e67e22/ffffff?text=Ao+Kieu+Nu+2',
                ],
                'attributes' => [
                    ['size' => 'S', 'color' => 'Hồng', 'price' => 180000, 'quantity' => 45],
                    ['size' => 'M', 'color' => 'Hồng', 'price' => 180000, 'quantity' => 80],
                    ['size' => 'L', 'color' => 'Hồng', 'price' => 180000, 'quantity' => 60],
                    ['size' => 'S', 'color' => 'Xanh', 'price' => 180000, 'quantity' => 50],
                    ['size' => 'M', 'color' => 'Xanh', 'price' => 180000, 'quantity' => 70],
                ],
            ],

            // Quần Nam
            [
                'name' => 'Quần Jean Nam Slim Fit',
                'category_id' => 3,
                'description' => 'Quần jean nam ôm body, co giãn 4 chiều, thoải mái',
                'base_price' => 350000,
                'images' => [
                    'https://via.placeholder.com/600x600/2c3e50/ffffff?text=Quan+Jean+1',
                    'https://via.placeholder.com/600x600/34495e/ffffff?text=Quan+Jean+2',
                ],
                'attributes' => [
                    ['size' => '29', 'color' => 'Xanh Đậm', 'price' => 350000, 'quantity' => 40],
                    ['size' => '30', 'color' => 'Xanh Đậm', 'price' => 350000, 'quantity' => 80],
                    ['size' => '31', 'color' => 'Xanh Đậm', 'price' => 350000, 'quantity' => 70],
                    ['size' => '32', 'color' => 'Xanh Đậm', 'price' => 350000, 'quantity' => 60],
                    ['size' => '30', 'color' => 'Đen', 'price' => 350000, 'quantity' => 90],
                ],
            ],

            // Quần Nữ
            [
                'name' => 'Quần Ống Rộng Nữ',
                'category_id' => 4,
                'description' => 'Quần ống rộng nữ thời trang, thoải mái, dễ phối đồ',
                'base_price' => 280000,
                'images' => [
                    'https://via.placeholder.com/600x600/16a085/ffffff?text=Quan+Ong+Rong+1',
                    'https://via.placeholder.com/600x600/1abc9c/ffffff?text=Quan+Ong+Rong+2',
                ],
                'attributes' => [
                    ['size' => 'S', 'color' => 'Đen', 'price' => 280000, 'quantity' => 55],
                    ['size' => 'M', 'color' => 'Đen', 'price' => 280000, 'quantity' => 85],
                    ['size' => 'L', 'color' => 'Đen', 'price' => 280000, 'quantity' => 65],
                    ['size' => 'M', 'color' => 'Be', 'price' => 280000, 'quantity' => 75],
                ],
            ],

            // Váy
            [
                'name' => 'Váy Maxi Nữ Dáng Dài',
                'category_id' => 5,
                'description' => 'Váy maxi dáng dài, thanh lịch, phù hợp đi dự tiệc',
                'base_price' => 450000,
                'images' => [
                    'https://via.placeholder.com/600x600/9b59b6/ffffff?text=Vay+Maxi+1',
                    'https://via.placeholder.com/600x600/8e44ad/ffffff?text=Vay+Maxi+2',
                ],
                'attributes' => [
                    ['size' => 'S', 'color' => 'Đỏ', 'price' => 450000, 'quantity' => 30],
                    ['size' => 'M', 'color' => 'Đỏ', 'price' => 450000, 'quantity' => 50],
                    ['size' => 'L', 'color' => 'Đỏ', 'price' => 450000, 'quantity' => 40],
                    ['size' => 'M', 'color' => 'Xanh Navy', 'price' => 450000, 'quantity' => 45],
                ],
            ],

            // Đầm
            [
                'name' => 'Đầm Công Sở Tay Lỡ',
                'category_id' => 6,
                'description' => 'Đầm công sở sang trọng, form dáng thanh lịch',
                'base_price' => 380000,
                'images' => [
                    'https://via.placeholder.com/600x600/27ae60/ffffff?text=Dam+Cong+So+1',
                    'https://via.placeholder.com/600x600/2ecc71/ffffff?text=Dam+Cong+So+2',
                ],
                'attributes' => [
                    ['size' => 'S', 'color' => 'Đen', 'price' => 380000, 'quantity' => 35],
                    ['size' => 'M', 'color' => 'Đen', 'price' => 380000, 'quantity' => 70],
                    ['size' => 'L', 'color' => 'Đen', 'price' => 380000, 'quantity' => 50],
                    ['size' => 'M', 'color' => 'Xám', 'price' => 380000, 'quantity' => 60],
                ],
            ],

            // Phụ Kiện
            [
                'name' => 'Mũ Lưỡi Trai Thêu Chữ',
                'category_id' => 7,
                'description' => 'Mũ lưỡi trai unisex, có thể điều chỉnh size',
                'base_price' => 80000,
                'images' => [
                    'https://via.placeholder.com/600x600/95a5a6/ffffff?text=Mu+Luoi+Trai+1',
                    'https://via.placeholder.com/600x600/7f8c8d/ffffff?text=Mu+Luoi+Trai+2',
                ],
                'attributes' => [
                    ['size' => 'Free Size', 'color' => 'Đen', 'price' => 80000, 'quantity' => 100],
                    ['size' => 'Free Size', 'color' => 'Trắng', 'price' => 80000, 'quantity' => 120],
                    ['size' => 'Free Size', 'color' => 'Đỏ', 'price' => 80000, 'quantity' => 80],
                ],
            ],

            // Giày Dép
            [
                'name' => 'Giày Thể Thao Nam Nữ',
                'category_id' => 8,
                'description' => 'Giày thể thao unisex, đế êm, thoáng khí',
                'base_price' => 550000,
                'images' => [
                    'https://via.placeholder.com/600x600/e74c3c/ffffff?text=Giay+The+Thao+1',
                    'https://via.placeholder.com/600x600/c0392b/ffffff?text=Giay+The+Thao+2',
                ],
                'attributes' => [
                    ['size' => '38', 'color' => 'Trắng', 'price' => 550000, 'quantity' => 40],
                    ['size' => '39', 'color' => 'Trắng', 'price' => 550000, 'quantity' => 60],
                    ['size' => '40', 'color' => 'Trắng', 'price' => 550000, 'quantity' => 70],
                    ['size' => '41', 'color' => 'Trắng', 'price' => 550000, 'quantity' => 65],
                    ['size' => '42', 'color' => 'Trắng', 'price' => 550000, 'quantity' => 50],
                    ['size' => '39', 'color' => 'Đen', 'price' => 550000, 'quantity' => 55],
                    ['size' => '40', 'color' => 'Đen', 'price' => 550000, 'quantity' => 75],
                ],
            ],

            // Túi Xách
            [
                'name' => 'Túi Xách Nữ Mini',
                'category_id' => 9,
                'description' => 'Túi xách nữ size mini, phong cách Hàn Quốc',
                'base_price' => 320000,
                'images' => [
                    'https://via.placeholder.com/600x600/f39c12/ffffff?text=Tui+Xach+1',
                    'https://via.placeholder.com/600x600/e67e22/ffffff?text=Tui+Xach+2',
                ],
                'attributes' => [
                    ['size' => null, 'color' => 'Đen', 'price' => 320000, 'quantity' => 45],
                    ['size' => null, 'color' => 'Nâu', 'price' => 320000, 'quantity' => 50],
                    ['size' => null, 'color' => 'Hồng', 'price' => 320000, 'quantity' => 40],
                ],
            ],

            // Đồ Thể Thao
            [
                'name' => 'Bộ Đồ Thể Thao Nam',
                'category_id' => 10,
                'description' => 'Bộ quần áo thể thao nam, thấm hút mồ hôi tốt',
                'base_price' => 420000,
                'images' => [
                    'https://via.placeholder.com/600x600/3498db/ffffff?text=Do+The+Thao+1',
                    'https://via.placeholder.com/600x600/2980b9/ffffff?text=Do+The+Thao+2',
                ],
                'attributes' => [
                    ['size' => 'M', 'color' => 'Đen', 'price' => 420000, 'quantity' => 50],
                    ['size' => 'L', 'color' => 'Đen', 'price' => 420000, 'quantity' => 70],
                    ['size' => 'XL', 'color' => 'Đen', 'price' => 420000, 'quantity' => 60],
                    ['size' => 'L', 'color' => 'Xám', 'price' => 420000, 'quantity' => 65],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'product_name' => $productData['name'],
                'category_id' => $productData['category_id'],
                'description' => $productData['description'],
                'base_price' => $productData['base_price'],
            ]);

            // Tạo images
            foreach ($productData['images'] as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imageUrl,
                    'is_main' => $index === 0,
                ]);
            }

            // Tạo attributes
            foreach ($productData['attributes'] as $attr) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'size' => $attr['size'],
                    'color' => $attr['color'],
                    'price' => $attr['price'],
                    'quantity' => $attr['quantity'],
                ]);
            }
        }
    }
}