<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Áo Nam',
            'Áo Nữ',
            'Quần Nam',
            'Quần Nữ',
            'Váy',
            'Đầm',
            'Phụ Kiện',
            'Giày Dép',
            'Túi Xách',
            'Đồ Thể Thao',
        ];

        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category,
            ]);
        }
    }
}