@extends('layouts.admin')

@section('title', 'Chi Tiết Danh Mục - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div class="flex items-center gap-3">
               <a href="{{ route('admin.categories.index') }}" 
                    class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left text-xl"></i>
               </a>
               <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $category->category_name }}</h1>
                    <p class="text-gray-600 mt-1">Chi tiết thông tin danh mục sản phẩm</p>
               </div>
          </div>
          
          <div class="flex gap-2">
               <a href="{{ route('admin.categories.edit', $category->id) }}" 
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-semibold">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh Sửa
               </a>
               
               <a href="{{ route('products.category', $category->id) }}" 
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Xem Frontend
               </a>
          </div>
     </div>
</div>

<!-- Category Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Sản Phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $category->products->count() }}</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Còn Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ $category->products->filter(function($p) { return $p->total_stock > 0; })->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Sắp Hết</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ $category->products->filter(function($p) { return $p->total_stock > 0 && $p->total_stock < 10; })->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-2xl text-yellow-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Hết Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ $category->products->filter(function($p) { return $p->total_stock == 0; })->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-2xl text-red-600"></i>
               </div>
          </div>
     </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
     <!-- Category Information -->
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
                         Tên Danh Mục
                         </label>
                         <div class="text-lg font-bold text-gray-900">{{ $category->category_name }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-hashtag text-purple-600 mr-2"></i>
                         ID
                         </label>
                         <div class="text-lg font-bold text-gray-900">#{{ $category->id }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-calendar-plus text-green-600 mr-2"></i>
                         Ngày Tạo
                         </label>
                         <div class="text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $category->created_at->diffForHumans() }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-clock text-yellow-600 mr-2"></i>
                         Cập Nhật Lần Cuối
                         </label>
                         <div class="text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $category->updated_at->diffForHumans() }}</div>
                    </div>
               </div>
          </div>
          
          <!-- Products List -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                         <h2 class="text-xl font-bold text-gray-900 flex items-center">
                         <i class="fas fa-box text-blue-600 mr-2"></i>
                         Sản Phẩm Trong Danh Mục ({{ $category->products->count() }})
                         </h2>
                         
                         @if($category->products->count() > 0)
                         <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" 
                              class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                              Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
                         </a>
                         @endif
                    </div>
               </div>
               
               @if($category->products->count() > 0)
                    <div class="divide-y divide-gray-200">
                         @foreach($category->products->take(10) as $product)
                         <div class="p-4 hover:bg-gray-50 transition">
                              <div class="flex items-center gap-4">
                                   <img src="{{ $product->main_image_url }}" 
                                        alt="{{ $product->product_name }}"
                                        class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                   
                                   <div class="flex-1 min-w-0">
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                        class="font-semibold text-gray-900 hover:text-blue-600 block truncate">
                                             {{ $product->product_name }}
                                        </a>
                                        
                                        <div class="flex items-center gap-3 mt-1 text-sm">
                                             <span class="text-blue-600 font-semibold">
                                             {{ number_format($product->base_price, 0, ',', '.') }}đ
                                             </span>
                                             
                                             @if($product->total_stock > 0)
                                             <span class="text-green-600">
                                                  <i class="fas fa-check-circle mr-1"></i>
                                                  Còn {{ $product->total_stock }}
                                             </span>
                                             @else
                                             <span class="text-red-600">
                                                  <i class="fas fa-times-circle mr-1"></i>
                                                  Hết hàng
                                             </span>
                                             @endif
                                             
                                             <span class="text-gray-500">
                                             <i class="fas fa-palette mr-1"></i>
                                             {{ $product->attributes->count() }} phân loại
                                             </span>
                                        </div>
                                   </div>
                                   
                                   <div class="flex gap-2 flex-shrink-0">
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                        title="Xem chi tiết">
                                             <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                        class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                        title="Chỉnh sửa">
                                             <i class="fas fa-edit"></i>
                                        </a>
                                   </div>
                              </div>
                         </div>
                         @endforeach
                    </div>
                    
                    @if($category->products->count() > 10)
                         <div class="px-6 py-4 bg-gray-50 text-center">
                         <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" 
                              class="text-blue-600 hover:text-blue-800 font-semibold">
                              Xem thêm {{ $category->products->count() - 10 }} sản phẩm khác
                              <i class="fas fa-arrow-right ml-1"></i>
                         </a>
                         </div>
                    @endif
               @else
                    <div class="text-center py-12">
                         <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                         <i class="fas fa-box-open text-6xl text-gray-400"></i>
                         </div>
                         <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa Có Sản Phẩm</h3>
                         <p class="text-gray-600 mb-6">Danh mục này chưa có sản phẩm nào</p>
                         <a href="{{ route('admin.products.create') }}" 
                         class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-plus mr-2"></i>
                         Thêm Sản Phẩm Đầu Tiên
                         </a>
                    </div>
               @endif
          </div>
     </div>
    
     <!-- Sidebar -->
     <div class="lg:col-span-1 space-y-6">
          <!-- Quick Actions -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Thao Tác Nhanh
               </h3>
               
               <div class="space-y-2">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                    class="block p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition text-sm font-semibold text-yellow-700">
                         <i class="fas fa-edit mr-2"></i>
                         Chỉnh Sửa Danh Mục
                    </a>
                    
                    <a href="{{ route('admin.products.create') }}" 
                    class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-sm font-semibold text-blue-700">
                         <i class="fas fa-plus mr-2"></i>
                         Thêm Sản Phẩm Mới
                    </a>
                    
                    <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" 
                    class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-sm font-semibold text-purple-700">
                         <i class="fas fa-box mr-2"></i>
                         Xem Tất Cả Sản Phẩm
                    </a>
                    
                    <a href="{{ route('products.category', $category->id) }}" 
                    target="_blank"
                    class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg transition text-sm font-semibold text-green-700">
                         <i class="fas fa-external-link-alt mr-2"></i>
                         Xem Ở Frontend
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
                         <span class="text-sm opacity-90">Tổng sản phẩm:</span>
                         <span class="font-bold text-lg">{{ $category->products->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Tổng tồn kho:</span>
                         <span class="font-bold text-lg">{{ $category->products->sum('total_stock') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Giá thấp nhất:</span>
                         <span class="font-bold text-lg">
                         @if($category->products->count() > 0)
                              {{ number_format($category->products->min('base_price'), 0, ',', '.') }}đ
                         @else
                              -
                         @endif
                         </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                         <span class="text-sm opacity-90">Giá cao nhất:</span>
                         <span class="font-bold text-lg">
                         @if($category->products->count() > 0)
                              {{ number_format($category->products->max('base_price'), 0, ',', '.') }}đ
                         @else
                              -
                         @endif
                         </span>
                    </div>
               </div>
          </div>
          
          <!-- Category Preview -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-desktop text-green-600 mr-2"></i>
                    Xem Trước Frontend
               </h3>
               
               <div class="p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                    <div class="flex items-center gap-3 mb-3">
                         <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                         <i class="fas fa-folder text-blue-600 text-xl"></i>
                         </div>
                         <div class="flex-1">
                         <div class="font-semibold text-gray-900">{{ $category->category_name }}</div>
                         <div class="text-xs text-gray-500 mt-1">
                              <i class="fas fa-box mr-1"></i>
                              {{ $category->products->count() }} sản phẩm
                         </div>
                         </div>
                    </div>
                    
                    <a href="{{ route('products.category', $category->id) }}" 
                    target="_blank"
                    class="block w-full text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                         <i class="fas fa-eye mr-2"></i>
                         Xem Trang Danh Mục
                    </a>
               </div>
          </div>
          
          <!-- Danger Zone -->
          @if($category->products->count() == 0)
               <div class="bg-red-50 rounded-lg border-2 border-red-200 p-6">
                    <h3 class="font-bold text-red-900 mb-3 flex items-center">
                         <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                         Xóa Danh Mục
                    </h3>
                    <p class="text-sm text-red-700 mb-4">
                         Danh mục này không có sản phẩm và có thể xóa. Hành động này không thể hoàn tác.
                    </p>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                         method="POST" 
                         onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA DANH MỤC NÀY?\n\nHành động này không thể hoàn tác!')">
                         @csrf
                         @method('DELETE')
                         <button type="submit" 
                              class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                         <i class="fas fa-trash-alt mr-2"></i>
                         Xóa Danh Mục
                         </button>
                    </form>
               </div>
          @endif
     </div>
</div>
@endsection