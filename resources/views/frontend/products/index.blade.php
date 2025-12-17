@extends('layouts.app')

@section('title', 'Sản Phẩm - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
            <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
            <li class="text-gray-600">Sản phẩm</li>
        </ol>
    </nav>
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                <h3 class="font-bold text-lg mb-4">Bộ Lọc</h3>
                
                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Danh Mục</h4>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input type="radio" name="category" value="{{ $category->id }}" 
                                           {{ request('category') == $category->id ? 'checked' : '' }}
                                           class="mr-2">
                                    <span class="text-sm">{{ $category->category_name }} ({{ $category->products_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Price Range -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Khoảng Giá</h4>
                        <div class="space-y-3">
                            <div>
                                <input type="number" name="min_price" placeholder="Từ" 
                                       value="{{ request('min_price') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <div>
                                <input type="number" name="max_price" placeholder="Đến" 
                                       value="{{ request('max_price') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm">
                            Áp Dụng
                        </button>
                        <a href="{{ route('products.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 text-sm text-center">
                            Xóa
                        </a>
                    </div>
                </form>
            </div>
        </aside>
        
        <!-- Products Grid -->
        <main class="flex-1">
            <!-- Toolbar -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-gray-600">
                    Hiển thị <span class="font-semibold">{{ $products->count() }}</span> / <span class="font-semibold">{{ $products->total() }}</span> sản phẩm
                </div>
                
                <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                    @foreach(request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <label class="text-sm text-gray-600">Sắp xếp:</label>
                    <select name="sort" onchange="this.form.submit()" 
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                    </select>
                </form>
            </div>
            
            <!-- Products -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
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
                                    <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 h-12">{{ $product->product_name }}</h3>
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
                                                <span class="text-lg font-bold text-blue-600">
                                                    {{ number_format($minPrice, 0, ',', '.') }}đ
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
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Không tìm thấy sản phẩm nào</p>
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">
                        Xem tất cả sản phẩm
                    </a>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection