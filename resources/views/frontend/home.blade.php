@extends('layouts.app')

@section('title', 'Trang Chủ - Fashion Shop')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-4">Chào Mừng Đến Fashion Shop</h1>
            <p class="text-xl mb-8">Khám phá bộ sưu tập thời trang mới nhất</p>
            <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Mua Sắm Ngay
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-8">Danh Mục Sản Phẩm</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->id) }}" 
                   class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-xl transition group">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-600 transition">
                        <i class="fas fa-tshirt text-2xl text-blue-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800">{{ $category->category_name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $category->products_count }} sản phẩm</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- New Products Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Sản Phẩm Mới Nhất</h2>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Xem Tất Cả <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($newProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->main_image_url }}" 
                                 alt="{{ $product->product_name }}"
                                 class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                            @if($product->created_at->diffInDays() < 7)
                                <span class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Mới
                                </span>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->product_name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $product->category->category_name }}</p>
                            
                            @php
                                $minPrice = $product->attributes->min('price');
                                $maxPrice = $product->attributes->max('price');
                            @endphp
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($minPrice == $maxPrice)
                                        <span class="text-xl font-bold text-blue-600">{{ number_format($minPrice, 0, ',', '.') }}đ</span>
                                    @else
                                        <span class="text-xl font-bold text-blue-600">
                                            {{ number_format($minPrice, 0, ',', '.') }}đ - {{ number_format($maxPrice, 0, ',', '.') }}đ
                                        </span>
                                    @endif
                                </div>
                                
                                @if($product->total_stock > 0)
                                    <span class="text-xs text-green-600">
                                        <i class="fas fa-check-circle"></i> Còn hàng
                                    </span>
                                @else
                                    <span class="text-xs text-red-600">
                                        <i class="fas fa-times-circle"></i> Hết hàng
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-8">Sản Phẩm Bán Chạy</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->main_image_url }}" 
                                 alt="{{ $product->product_name }}"
                                 class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                            <span class="absolute top-2 right-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-fire"></i> Hot
                            </span>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $product->product_name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $product->category->category_name }}</p>
                            
                            @php
                                $minPrice = $product->attributes->min('price');
                                $maxPrice = $product->attributes->max('price');
                            @endphp
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($minPrice == $maxPrice)
                                        <span class="text-xl font-bold text-blue-600">{{ number_format($minPrice, 0, ',', '.') }}đ</span>
                                    @else
                                        <span class="text-xl font-bold text-blue-600">
                                            {{ number_format($minPrice, 0, ',', '.') }}đ - {{ number_format($maxPrice, 0, ',', '.') }}đ
                                        </span>
                                    @endif
                                </div>
                                
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-shopping-cart"></i> {{ $product->order_details_count }} đã bán
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shipping-fast text-2xl text-blue-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Miễn Phí Vận Chuyển</h3>
                <p class="text-sm text-gray-500">Cho đơn hàng từ 500.000đ</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-undo text-2xl text-green-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Đổi Trả Dễ Dàng</h3>
                <p class="text-sm text-gray-500">Trong vòng 7 ngày</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-headset text-2xl text-yellow-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Hỗ Trợ 24/7</h3>
                <p class="text-sm text-gray-500">Tư vấn nhiệt tình</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-2xl text-purple-600"></i>
                </div>
                <h3 class="font-semibold mb-2">Thanh Toán An Toàn</h3>
                <p class="text-sm text-gray-500">Bảo mật tuyệt đối</p>
            </div>
        </div>
    </div>
</section>
@endsection