@extends('layouts.admin')

@section('title', 'Chi Tiết Sản Phẩm - Admin')

@section('content')
<div class="mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" 
                class="text-gray-600 hover:text-gray-900 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->product_name }}</h1>
                <p class="text-gray-600 mt-1">Chi tiết thông tin sản phẩm</p>
            </div>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" 
                class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-semibold">
                <i class="fas fa-edit mr-2"></i>
                Chỉnh Sửa
            </a>
            
            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                method="POST" 
                class="inline"
                onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA SẢN PHẨM NÀY?\n\nHành động này không thể hoàn tác!')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                    <i class="fas fa-trash mr-2"></i>
                    Xóa
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Product Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Giá Cơ Bản</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($product->base_price, 0, ',', '.') }}đ</h3>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-dollar-sign text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Tổng Tồn Kho</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $product->total_stock }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-boxes text-2xl text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Biến Thể</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $product->attributes->count() }}</h3>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-layer-group text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Hình Ảnh</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $product->images->count() }}</h3>
            </div>
            <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center">
                <i class="fas fa-images text-2xl text-indigo-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Product Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Thông Tin Cơ Bản
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-tag text-blue-600 mr-2"></i>
                        Tên Sản Phẩm
                    </label>
                    <div class="text-lg font-bold text-gray-900">{{ $product->product_name }}</div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-hashtag text-purple-600 mr-2"></i>
                        ID
                    </label>
                    <div class="text-lg font-bold text-gray-900">#{{ $product->id }}</div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-folder text-indigo-600 mr-2"></i>
                        Danh Mục
                    </label>
                    <div>
                        <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                            <i class="fas fa-folder-open mr-2"></i>
                            {{ $product->category->category_name }}
                        </span>
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-dollar-sign text-green-600 mr-2"></i>
                        Giá Cơ Bản
                    </label>
                    <div class="text-lg font-bold text-blue-600">{{ number_format($product->base_price, 0, ',', '.') }}đ</div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-boxes text-green-600 mr-2"></i>
                        Tổng Tồn Kho
                    </label>
                    <div>
                        @if($product->total_stock > 10)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ $product->total_stock }} sản phẩm
                            </span>
                        @elseif($product->total_stock > 0)
                            <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $product->total_stock }} sản phẩm
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                <i class="fas fa-times-circle mr-2"></i>
                                Hết hàng
                            </span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-box text-orange-600 mr-2"></i>
                        Trạng Thái
                    </label>
                    <div>
                        @if($product->inStock())
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                <i class="fas fa-check mr-2"></i>
                                Còn hàng
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                <i class="fas fa-times mr-2"></i>
                                Hết hàng
                            </span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-calendar-plus text-green-600 mr-2"></i>
                        Ngày Tạo
                    </label>
                    <div class="text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $product->created_at->diffForHumans() }}</div>
                </div>
                
                <div>
                    <label class="text-sm font-semibold text-gray-600 block mb-2">
                        <i class="fas fa-clock text-yellow-600 mr-2"></i>
                        Cập Nhật Lần Cuối
                    </label>
                    <div class="text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $product->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        @if($product->description)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-align-left text-blue-600 mr-2"></i>
                Mô Tả Chi Tiết
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
        @endif
        
        <!-- Product Attributes -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-layer-group text-blue-600 mr-2"></i>
                        Biến Thể Sản Phẩm ({{ $product->attributes->count() }})
                    </h2>
                </div>
            </div>
            
            @if($product->attributes->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($product->attributes as $attribute)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 mb-2">
                                    {{ $attribute->variant_name }}
                                </div>
                                
                                <div class="flex items-center gap-4 text-sm">
                                    @if($attribute->size)
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded">
                                        <i class="fas fa-ruler mr-1"></i>
                                        {{ $attribute->size }}
                                    </span>
                                    @endif
                                    
                                    @if($attribute->color)
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded">
                                        <i class="fas fa-palette mr-1"></i>
                                        {{ $attribute->color }}
                                    </span>
                                    @endif
                                    
                                    <span class="text-blue-600 font-semibold">
                                        <i class="fas fa-dollar-sign mr-1"></i>
                                        {{ number_format($attribute->price, 0, ',', '.') }}đ
                                    </span>
                                    
                                    @if($attribute->isInStock())
                                        <span class="text-green-600 font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Còn {{ $attribute->quantity }}
                                        </span>
                                    @else
                                        <span class="text-red-600 font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Hết hàng
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0">
                                @if($attribute->isInStock())
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                        Còn hàng
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                        Hết hàng
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-layer-group text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa Có Biến Thể</h3>
                    <p class="text-gray-600">Sản phẩm này chưa có biến thể nào</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Images -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-images text-blue-600 mr-2"></i>
                Hình Ảnh Sản Phẩm
            </h3>
            
            @if($product->mainImage)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $product->mainImage->image_url) }}" 
                        alt="{{ $product->product_name }}"
                        class="w-full h-64 object-cover rounded-lg shadow-md">
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                            <i class="fas fa-star mr-1"></i>Hình chính
                        </span>
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-400 mb-4">
                    <i class="fas fa-image text-5xl mb-3"></i>
                    <p>Chưa có hình ảnh chính</p>
                </div>
            @endif
            
            @if($product->images->count() > 1)
                <hr class="my-4">
                <h6 class="font-semibold text-gray-700 mb-3">
                    Tất cả hình ảnh ({{ $product->images->count() }})
                </h6>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($product->images as $image)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                alt="{{ $product->product_name }}"
                                class="w-full h-24 object-cover rounded-lg shadow-sm hover:shadow-md transition">
                            @if($image->is_main)
                                <span class="absolute top-1 right-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                    <i class="fas fa-star"></i>
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                Thao Tác Nhanh
            </h3>
            
            <div class="space-y-2">
                <a href="{{ route('admin.products.edit', $product->id) }}" 
                    class="block p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition text-sm font-semibold text-yellow-700">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh Sửa Sản Phẩm
                </a>
                
                <a href="{{ route('admin.products.index', ['category_id' => $product->category_id]) }}" 
                    class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-sm font-semibold text-purple-700">
                    <i class="fas fa-folder mr-2"></i>
                    Xem Danh Mục
                </a>
                
                <a href="{{ route('admin.products.index') }}" 
                    class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-sm font-semibold text-blue-700">
                    <i class="fas fa-box mr-2"></i>
                    Tất Cả Sản Phẩm
                </a>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
            <h3 class="font-bold mb-4 flex items-center">
                <i class="fas fa-chart-pie mr-2"></i>
                Thống Kê Chi Tiết
            </h3>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center pb-3 border-b border-white/20">
                    <span class="text-sm opacity-90">Tổng biến thể:</span>
                    <span class="font-bold text-lg">{{ $product->attributes->count() }}</span>
                </div>
                
                <div class="flex justify-between items-center pb-3 border-b border-white/20">
                    <span class="text-sm opacity-90">Tổng tồn kho:</span>
                    <span class="font-bold text-lg">{{ $product->total_stock }}</span>
                </div>
                
                <div class="flex justify-between items-center pb-3 border-b border-white/20">
                    <span class="text-sm opacity-90">Số hình ảnh:</span>
                    <span class="font-bold text-lg">{{ $product->images->count() }}</span>
                </div>
                
                <div class="flex justify-between items-center pb-3 border-b border-white/20">
                    <span class="text-sm opacity-90">Giá thấp nhất:</span>
                    <span class="font-bold text-lg">
                        @if($product->attributes->count() > 0)
                            {{ number_format($product->attributes->min('price'), 0, ',', '.') }}đ
                        @else
                            {{ number_format($product->base_price, 0, ',', '.') }}đ
                        @endif
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm opacity-90">Giá cao nhất:</span>
                    <span class="font-bold text-lg">
                        @if($product->attributes->count() > 0)
                            {{ number_format($product->attributes->max('price'), 0, ',', '.') }}đ
                        @else
                            {{ number_format($product->base_price, 0, ',', '.') }}đ
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Danger Zone -->
        <div class="bg-red-50 rounded-lg border-2 border-red-200 p-6">
            <h3 class="font-bold text-red-900 mb-3 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                Xóa Sản Phẩm
            </h3>
            <p class="text-sm text-red-700 mb-4">
                Xóa vĩnh viễn sản phẩm này. Hành động này không thể hoàn tác.
            </p>
            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                method="POST" 
                onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA SẢN PHẨM NÀY?\n\nTất cả biến thể, hình ảnh và dữ liệu liên quan sẽ bị xóa!\nHành động này không thể hoàn tác!')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Xóa Sản Phẩm
                </button>
            </form>
        </div>
    </div>
</div>
@endsection