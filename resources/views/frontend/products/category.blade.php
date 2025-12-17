@extends('layouts.app')

@section('title', $category->category_name . ' - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
     <nav class="mb-6 text-sm">
          <ol class="flex items-center space-x-2">
               <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
               <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
               <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Sản phẩm</a></li>
               <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
               <li class="text-gray-600">{{ $category->category_name }}</li>
          </ol>
     </nav>
    
    <!-- Category Header -->
     <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-8 mb-8">
          <div class="flex items-center justify-between">
               <div>
                    <h1 class="text-4xl font-bold mb-2">{{ $category->category_name }}</h1>
                    <p class="text-lg opacity-90">
                         <i class="fas fa-box mr-2"></i>
                         {{ $products->total() }} sản phẩm
                    </p>
               </div>
               <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                         <i class="fas fa-tshirt text-5xl"></i>
                    </div>
               </div>
          </div>
     </div>
    
     <div class="flex flex-col lg:flex-row gap-6">
          <!-- Sidebar -->
          <aside class="w-full lg:w-64 flex-shrink-0">
               <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h3 class="font-bold text-lg mb-4">
                         <i class="fas fa-filter mr-2 text-blue-600"></i>
                         Bộ Lọc
                    </h3>
                    
                    <form action="{{ route('products.category', $category->id) }}" method="GET">
                         <!-- All Categories -->
                         <div class="mb-6">
                         <h4 class="font-semibold mb-3 text-gray-700">Danh Mục Khác</h4>
                         <div class="space-y-2 max-h-64 overflow-y-auto">
                              @foreach($categories as $cat)
                                   <a href="{{ route('products.category', $cat->id) }}" 
                                        class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition {{ $cat->id == $category->id ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700' }}">
                                        <span class="text-sm">{{ $cat->category_name }}</span>
                                        <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $cat->products_count }}</span>
                                   </a>
                              @endforeach
                         </div>
                         </div>
                         
                         <hr class="my-4">
                         
                         <!-- Price Range -->
                         <div class="mb-6">
                         <h4 class="font-semibold mb-3 text-gray-700">Khoảng Giá</h4>
                         <div class="space-y-3">
                              <div>
                                   <label class="text-xs text-gray-600 mb-1 block">Từ (đ)</label>
                                   <input type="number" 
                                        name="min_price" 
                                        placeholder="0" 
                                        value="{{ request('min_price') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                              </div>
                              <div>
                                   <label class="text-xs text-gray-600 mb-1 block">Đến (đ)</label>
                                   <input type="number" 
                                        name="max_price" 
                                        placeholder="1000000" 
                                        value="{{ request('max_price') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                              </div>
                         </div>
                         
                         <!-- Quick Price Filters -->
                         <div class="mt-3 space-y-2">
                              <button type="button" 
                                        onclick="document.querySelector('input[name=min_price]').value=''; document.querySelector('input[name=max_price]').value='200000'; this.form.submit();"
                                        class="w-full text-left px-3 py-2 text-sm bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                   Dưới 200,000đ
                              </button>
                              <button type="button" 
                                        onclick="document.querySelector('input[name=min_price]').value='200000'; document.querySelector('input[name=max_price]').value='500000'; this.form.submit();"
                                        class="w-full text-left px-3 py-2 text-sm bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                   200,000đ - 500,000đ
                              </button>
                              <button type="button" 
                                        onclick="document.querySelector('input[name=min_price]').value='500000'; document.querySelector('input[name=max_price]').value='1000000'; this.form.submit();"
                                        class="w-full text-left px-3 py-2 text-sm bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                   500,000đ - 1,000,000đ
                              </button>
                              <button type="button" 
                                        onclick="document.querySelector('input[name=min_price]').value='1000000'; document.querySelector('input[name=max_price]').value=''; this.form.submit();"
                                        class="w-full text-left px-3 py-2 text-sm bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                   Trên 1,000,000đ
                              </button>
                         </div>
                         </div>
                         
                         <hr class="my-4">
                         
                         <!-- Availability -->
                         <div class="mb-6">
                         <h4 class="font-semibold mb-3 text-gray-700">Tình Trạng</h4>
                         <div class="space-y-2">
                              <label class="flex items-center cursor-pointer">
                                   <input type="checkbox" 
                                        name="in_stock" 
                                        value="1"
                                        {{ request('in_stock') ? 'checked' : '' }}
                                        class="mr-2 w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                   <span class="text-sm text-gray-700">Còn hàng</span>
                              </label>
                         </div>
                         </div>
                         
                         <!-- Buttons -->
                         <div class="flex gap-2">
                         <button type="submit" 
                                   class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 text-sm font-semibold transition">
                              <i class="fas fa-check mr-1"></i>
                              Áp Dụng
                         </button>
                         <a href="{{ route('products.category', $category->id) }}" 
                              class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 text-sm font-semibold text-center transition">
                              <i class="fas fa-redo mr-1"></i>
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
                    <div class="text-gray-600 text-sm">
                         Hiển thị <span class="font-semibold">{{ $products->firstItem() ?? 0 }}</span> - 
                         <span class="font-semibold">{{ $products->lastItem() ?? 0 }}</span> 
                         trong <span class="font-semibold">{{ $products->total() }}</span> sản phẩm
                    </div>
                    
                    <form action="{{ route('products.category', $category->id) }}" method="GET" class="flex items-center gap-2">
                         @foreach(request()->except('sort') as $key => $value)
                         <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                         @endforeach
                         
                         <label class="text-sm text-gray-600">Sắp xếp:</label>
                         <select name="sort" 
                              onchange="this.form.submit()" 
                              class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                         <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                         <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                         <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                         <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                         <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Bán chạy</option>
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
                                             <span class="absolute top-2 left-2 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                             <i class="fas fa-star mr-1"></i>
                                             Mới
                                             </span>
                                        @endif
                                        
                                        @if($product->total_stock > 0 && $product->total_stock < 10)
                                             <span class="absolute top-2 right-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                             <i class="fas fa-fire mr-1"></i>
                                             Sắp hết
                                             </span>
                                        @endif
                                        
                                        @if($product->total_stock == 0)
                                             <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                             <span class="bg-white text-gray-800 px-4 py-2 rounded-lg font-semibold">
                                                  Hết hàng
                                             </span>
                                             </div>
                                        @endif
                                   </div>
                                   
                                   <div class="p-4">
                                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 h-12">
                                             {{ $product->product_name }}
                                        </h3>
                                        
                                        @php
                                             $minPrice = $product->attributes->min('price');
                                             $maxPrice = $product->attributes->max('price');
                                        @endphp
                                        
                                        <div class="flex items-center justify-between mb-2">
                                             <div>
                                             @if($minPrice == $maxPrice)
                                                  <span class="text-xl font-bold text-blue-600">{{ number_format($minPrice, 0, ',', '.') }}đ</span>
                                             @else
                                                  <div class="flex flex-col">
                                                       <span class="text-lg font-bold text-blue-600">
                                                            {{ number_format($minPrice, 0, ',', '.') }}đ
                                                       </span>
                                                       <span class="text-xs text-gray-500">
                                                            - {{ number_format($maxPrice, 0, ',', '.') }}đ
                                                       </span>
                                                  </div>
                                             @endif
                                             </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between text-xs">
                                             @if($product->total_stock > 0)
                                             <span class="text-green-600">
                                                  <i class="fas fa-check-circle"></i> 
                                                  Còn {{ $product->total_stock }} sp
                                             </span>
                                             @else
                                             <span class="text-red-600">
                                                  <i class="fas fa-times-circle"></i> 
                                                  Hết hàng
                                             </span>
                                             @endif
                                             
                                             <span class="text-gray-500">
                                             <i class="fas fa-palette"></i> 
                                             {{ $product->attributes->count() }} phân loại
                                             </span>
                                        </div>
                                   </div>
                              </a>
                         </div>
                         @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                         {{ $products->appends(request()->query())->links() }}
                    </div>
               @else
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                         <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                         <h2 class="text-2xl font-bold text-gray-800 mb-2">Không có sản phẩm</h2>
                         <p class="text-gray-600 mb-6">
                         Không tìm thấy sản phẩm nào trong danh mục này với bộ lọc hiện tại.
                         </p>
                         
                         <div class="flex justify-center gap-4">
                         <a href="{{ route('products.category', $category->id) }}" 
                              class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                              <i class="fas fa-redo mr-2"></i>
                              Xóa Bộ Lọc
                         </a>
                         <a href="{{ route('products.index') }}" 
                              class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                              <i class="fas fa-th mr-2"></i>
                              Xem Tất Cả
                         </a>
                         </div>
                    </div>
               @endif
          </main>
     </div>
    
    <!-- Category Description (SEO) -->
     @if($products->count() > 0)
          <div class="mt-12 bg-gray-50 rounded-lg p-8">
               <h2 class="text-2xl font-bold mb-4">Về {{ $category->category_name }}</h2>
               <div class="prose max-w-none text-gray-700">
                    <p>
                         Khám phá bộ sưu tập <strong>{{ $category->category_name }}</strong> đa dạng và phong phú tại Fashion Shop. 
                         Với hơn <strong>{{ $products->total() }} sản phẩm</strong> chất lượng cao, giá cả phải chăng, 
                         chúng tôi cam kết mang đến cho bạn những sản phẩm thời trang tốt nhất.
                    </p>
                    <p class="mt-4">
                         Tất cả sản phẩm {{ $category->category_name }} đều được chọn lọc kỹ lưỡng về chất liệu, 
                         thiết kế và xu hướng thời trang hiện đại. Với chính sách đổi trả linh hoạt và 
                         giao hàng nhanh chóng, mua sắm tại Fashion Shop thật dễ dàng và yên tâm.
                    </p>
               </div>
          </div>
     @endif
</div>
@endsection