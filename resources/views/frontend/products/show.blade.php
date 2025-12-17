@extends('layouts.app')

@section('title', $product->product_name . ' - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
            <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
            <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Sản phẩm</a></li>
            <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
            <li class="text-gray-600">{{ $product->product_name }}</li>
        </ol>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Product Images -->
        <div x-data="{ mainImage: '{{ $product->main_image_url }}' }">
            <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                <img :src="mainImage" alt="{{ $product->product_name }}" 
                     class="w-full h-96 object-cover rounded-lg">
            </div>
            
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->images as $image)
                    <div @click="mainImage = '{{ asset('storage/' . $image->image_url) }}'" 
                        class="cursor-pointer bg-white rounded-lg shadow-md p-2 hover:shadow-lg transition">
                        <img src="{{ asset('storage/' . $image->image_url) }}" 
                            alt="{{ $product->product_name }}" 
                            class="w-full h-20 object-cover rounded">
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->product_name }}</h1>
            
            <div class="flex items-center gap-4 mb-4">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-tag mr-1"></i>
                    {{ $product->category->category_name }}
                </span>
                
                @if($product->total_stock > 0)
                    <span class="text-sm text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>
                        Còn {{ $product->total_stock }} sản phẩm
                    </span>
                @else
                    <span class="text-sm text-red-600">
                        <i class="fas fa-times-circle mr-1"></i>
                        Hết hàng
                    </span>
                @endif
            </div>
            
            <div class="border-t border-b border-gray-200 py-4 mb-6">
                @php
                    $minPrice = $product->attributes->min('price');
                    $maxPrice = $product->attributes->max('price');
                @endphp
                
                @if($minPrice == $maxPrice)
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($minPrice, 0, ',', '.') }}đ</div>
                @else
                    <div class="text-3xl font-bold text-blue-600">
                        {{ number_format($minPrice, 0, ',', '.') }}đ - {{ number_format($maxPrice, 0, ',', '.') }}đ
                    </div>
                @endif
            </div>
            
            <!-- Add to Cart Form -->
            <form action="{{ route('cart.add') }}" method="POST" 
                  x-data="{ 
                      selectedAttribute: null,
                      quantity: 1,
                      maxQuantity: 0,
                      price: 0
                  }">
                @csrf
                
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="product_attribute_id" x-model="selectedAttribute">
                <input type="hidden" name="quantity" x-model="quantity">
                
                <!-- Size/Color Selection -->
                <div class="mb-6">
                    <h3 class="font-semibold mb-3">Chọn Phân Loại:</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($product->attributes as $attr)
                            <button type="button"
                                    @click="selectedAttribute = {{ $attr->id }}; maxQuantity = {{ $attr->quantity }}; price = {{ $attr->price }}; quantity = 1"
                                    :class="selectedAttribute === {{ $attr->id }} ? 'border-blue-600 bg-blue-50' : 'border-gray-300'"
                                    class="border-2 rounded-lg p-3 text-left hover:border-blue-600 transition"
                                    {{ $attr->quantity == 0 ? 'disabled' : '' }}>
                                <div class="flex justify-between items-start">
                                    <div>
                                        @if($attr->size)
                                            <div class="font-semibold">Size: {{ $attr->size }}</div>
                                        @endif
                                        @if($attr->color)
                                            <div class="text-sm text-gray-600">Màu: {{ $attr->color }}</div>
                                        @endif
                                        <div class="text-blue-600 font-bold mt-1">{{ number_format($attr->price, 0, ',', '.') }}đ</div>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $attr->quantity > 0 ? 'Còn ' . $attr->quantity : 'Hết hàng' }}
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                    
                    <div x-show="!selectedAttribute" class="text-sm text-red-600 mt-2">
                        * Vui lòng chọn phân loại
                    </div>
                </div>
                
                <!-- Quantity -->
                <div class="mb-6" x-show="selectedAttribute">
                    <h3 class="font-semibold mb-3">Số Lượng:</h3>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" 
                                    class="px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" x-model="quantity" :max="maxQuantity" min="1"
                                   class="w-16 text-center border-x border-gray-300 py-2">
                            <button type="button" @click="quantity = Math.min(maxQuantity, quantity + 1)" 
                                    class="px-4 py-2 hover:bg-gray-100">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <span class="text-sm text-gray-500" x-text="`Còn ${maxQuantity} sản phẩm`"></span>
                    </div>
                </div>
                
                <!-- Total Price -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4" x-show="selectedAttribute">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Tạm tính:</span>
                        <span class="text-2xl font-bold text-blue-600" x-text="(price * quantity).toLocaleString('vi-VN') + 'đ'"></span>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            :disabled="!selectedAttribute"
                            :class="selectedAttribute ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-300 cursor-not-allowed'"
                            class="flex-1 text-white py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Thêm Vào Giỏ Hàng
                    </button>
                    
                    <button type="button" class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Product Description -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Mô Tả Sản Phẩm</h2>
        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-6">Sản Phẩm Liên Quan</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                    <a href="{{ route('products.show', $relatedProduct->id) }}">
                        <div class="relative overflow-hidden">
                            <img src="{{ $relatedProduct->main_image_url }}" 
                                 alt="{{ $relatedProduct->product_name }}"
                                 class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $relatedProduct->product_name }}</h3>
                            
                            @php
                                $minPrice = $relatedProduct->attributes->min('price');
                                $maxPrice = $relatedProduct->attributes->max('price');
                            @endphp
                            
                            @if($minPrice == $maxPrice)
                                <span class="text-xl font-bold text-blue-600">{{ number_format($minPrice, 0, ',', '.') }}đ</span>
                            @else
                                <span class="text-lg font-bold text-blue-600">
                                    {{ number_format($minPrice, 0, ',', '.') }}đ - {{ number_format($maxPrice, 0, ',', '.') }}đ
                                </span>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
</div>
@endsection