@extends('layouts.admin')

@section('title', 'Quản Lý Sản Phẩm - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Quản Lý Sản Phẩm</h1>
               <p class="text-gray-600 mt-1">Quản lý tất cả sản phẩm trong cửa hàng</p>
          </div>
          <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg">
               <i class="fas fa-plus mr-2"></i>
               Thêm Sản Phẩm
          </a>
     </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Sản Phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $products->total() }}</h3>
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
                         {{ $products->filter(function($p) { return $p->total_stock > 0; })->count() }}
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
                         {{ $products->filter(function($p) { return $p->total_stock > 0 && $p->total_stock < 10; })->count() }}
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
                         {{ $products->filter(function($p) { return $p->total_stock == 0; })->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-2xl text-red-600"></i>
               </div>
          </div>
     </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
     <!-- Table Header with Filters -->
     <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
               <h2 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-table mr-2 text-blue-600"></i>
                    Danh Sách Sản Phẩm
               </h2>
               
               <!-- Search & Filter Form -->
               <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                    <!-- Search -->
                    <input type="text" 
                         name="search" 
                         value="{{ request('search') }}"
                         placeholder="Tìm kiếm sản phẩm..." 
                         class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-64">
                    
                    <!-- Category Filter -->
                    <select name="category_id" 
                         class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         <option value="">Tất cả danh mục</option>
                         @foreach($categories as $category)
                         <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                              {{ $category->category_name }} ({{ $category->products_count }})
                         </option>
                         @endforeach
                    </select>
                    
                    <!-- Submit & Reset -->
                    <button type="submit" 
                         class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                         <i class="fas fa-search"></i>
                    </button>
                    
                    @if(request('search') || request('category_id'))
                         <a href="{{ route('admin.products.index') }}" 
                         class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                         <i class="fas fa-times"></i>
                         </a>
                    @endif
               </form>
          </div>
     </div>
    
     <!-- Table -->
     @if($products->count() > 0)
          <div class="overflow-x-auto">
               <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                         <tr>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Sản Phẩm
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Danh Mục
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Giá
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Tồn Kho
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Trạng Thái
                         </th>
                         <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Thao Tác
                         </th>
                         </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                         @foreach($products as $product)
                         <tr class="hover:bg-gray-50 transition">
                              <!-- Product Info -->
                              <td class="px-6 py-4">
                                   <div class="flex items-center gap-4">
                                        <div class="relative flex-shrink-0">
                                             <img src="{{ $product->main_image_url }}" 
                                                  alt="{{ $product->product_name }}"
                                                  class="w-16 h-16 object-cover rounded-lg">
                                             @if($product->created_at->diffInDays() < 7)
                                             <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold">
                                                  Mới
                                             </span>
                                             @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                             <a href="{{ route('admin.products.show', $product->id) }}" 
                                             class="font-semibold text-gray-900 hover:text-blue-600 line-clamp-2">
                                             {{ $product->product_name }}
                                             </a>
                                             <div class="text-xs text-gray-500 mt-1">
                                             <i class="fas fa-palette mr-1"></i>
                                             {{ $product->attributes->count() }} phân loại
                                             </div>
                                        </div>
                                   </div>
                              </td>
                              
                              <!-- Category -->
                              <td class="px-6 py-4 whitespace-nowrap">
                                   <a href="{{ route('admin.categories.show', $product->category->id) }}"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 hover:bg-purple-200 transition">
                                        <i class="fas fa-folder mr-1"></i>
                                        {{ $product->category->category_name }}
                                   </a>
                              </td>
                              
                              <!-- Price -->
                              <td class="px-6 py-4 whitespace-nowrap">
                                   @php
                                        $minPrice = $product->attributes->min('price');
                                        $maxPrice = $product->attributes->max('price');
                                   @endphp
                                   <div class="text-sm font-semibold text-gray-900">
                                        @if($minPrice == $maxPrice)
                                             {{ number_format($minPrice, 0, ',', '.') }}đ
                                        @else
                                             <div>{{ number_format($minPrice, 0, ',', '.') }}đ</div>
                                             <div class="text-xs text-gray-500">- {{ number_format($maxPrice, 0, ',', '.') }}đ</div>
                                        @endif
                                   </div>
                              </td>
                              
                              <!-- Stock -->
                              <td class="px-6 py-4 whitespace-nowrap">
                                   <div class="flex items-center">
                                        @if($product->total_stock > 10)
                                             <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                             <i class="fas fa-check-circle mr-1"></i>
                                             {{ $product->total_stock }}
                                             </span>
                                        @elseif($product->total_stock > 0)
                                             <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                             <i class="fas fa-exclamation-triangle mr-1"></i>
                                             {{ $product->total_stock }}
                                             </span>
                                        @else
                                             <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                             <i class="fas fa-times-circle mr-1"></i>
                                             Hết hàng
                                             </span>
                                        @endif
                                   </div>
                              </td>
                              
                              <!-- Status -->
                              <td class="px-6 py-4 whitespace-nowrap">
                                   @if($product->total_stock > 0)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                             <i class="fas fa-check mr-1"></i>
                                             Đang bán
                                        </span>
                                   @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                             <i class="fas fa-pause mr-1"></i>
                                             Tạm ngưng
                                        </span>
                                   @endif
                              </td>
                              
                              <!-- Actions -->
                              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                   <div class="flex items-center justify-end gap-2">
                                        <!-- View -->
                                        <a href="{{ route('admin.products.show', $product->id) }}" 
                                        class="text-blue-600 hover:text-blue-900 transition"
                                        title="Xem chi tiết">
                                             <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Edit -->
                                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                                        class="text-yellow-600 hover:text-yellow-900 transition"
                                        title="Chỉnh sửa">
                                             <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                             method="POST" 
                                             class="inline"
                                             onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?\nHành động này sẽ xóa tất cả ảnh và biến thể liên quan!')">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" 
                                                  class="text-red-600 hover:text-red-900 transition"
                                                  title="Xóa">
                                             <i class="fas fa-trash"></i>
                                             </button>
                                        </form>
                                   </div>
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
               </table>
          </div>
          
          <!-- Pagination -->
          <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
               {{ $products->appends(request()->query())->links() }}
          </div>
     @else
          <!-- Empty State -->
          <div class="text-center py-12">
               <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-box-open text-6xl text-gray-400"></i>
               </div>
               <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    @if(request('search') || request('category_id'))
                         Không Tìm Thấy Sản Phẩm
                    @else
                         Chưa Có Sản Phẩm Nào
                    @endif
               </h3>
               <p class="text-gray-600 mb-6">
                    @if(request('search'))
                         Không tìm thấy sản phẩm nào phù hợp với "{{ request('search') }}"
                    @elseif(request('category_id'))
                         Không có sản phẩm nào trong danh mục này
                    @else
                         Hãy thêm sản phẩm đầu tiên vào cửa hàng của bạn
                    @endif
               </p>
               
               @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.products.index') }}" 
                    class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-semibold">
                         <i class="fas fa-times mr-2"></i>
                         Xóa Bộ Lọc
                    </a>
               @else
                    <a href="{{ route('admin.products.create') }}" 
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-plus mr-2"></i>
                         Thêm Sản Phẩm Đầu Tiên
                    </a>
               @endif
          </div>
    @endif
</div>

<!-- Quick Tips -->
@if($products->count() > 0)
     <div class="mt-6 bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
          <div class="flex items-start gap-4">
               <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-2xl text-blue-600"></i>
               </div>
               <div class="flex-1">
                    <h3 class="font-bold text-gray-900 mb-2">
                         <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                         Mẹo Quản Lý Sản Phẩm
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Cập nhật ảnh chất lượng cao để thu hút khách hàng</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Thường xuyên kiểm tra tồn kho để tránh hết hàng</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Viết mô tả chi tiết giúp khách hàng hiểu rõ sản phẩm</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Đặt giá cạnh tranh và cập nhật phân loại đầy đủ</span>
                         </li>
                    </ul>
               </div>
          </div>
     </div>
@endif
@endsection