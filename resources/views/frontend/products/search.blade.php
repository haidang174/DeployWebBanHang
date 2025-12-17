@extends('layouts.app')

@section('title', 'Tìm kiếm "' . $keyword . '" - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
     <nav class="mb-6 text-sm">
          <ol class="flex items-center space-x-2">
               <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
               <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
               <li class="text-gray-600">Tìm kiếm</li>
          </ol>
     </nav>
    
    <!-- Search Header -->
     <div class="mb-8">
          <h1 class="text-3xl font-bold mb-4">
               Kết quả tìm kiếm cho "{{ $keyword }}"
          </h1>
          
          <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
               <p class="text-gray-600">
                    Tìm thấy <span class="font-semibold text-blue-600">{{ $products->total() }}</span> sản phẩm
               </p>
               
               <!-- Search Form -->
               <form action="{{ route('products.search') }}" method="GET" class="w-full sm:w-auto">
                    <div class="relative">
                         <input type="text" 
                              name="q" 
                              value="{{ $keyword }}"
                              placeholder="Tìm kiếm sản phẩm..." 
                              class="w-full sm:w-96 px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                         <button type="submit" 
                              class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600">
                         <i class="fas fa-search"></i>
                         </button>
                    </div>
               </form>
          </div>
     </div>
    
     @if($products->count() > 0)
          <!-- Toolbar -->
          <div class="bg-white rounded-lg shadow-md p-4 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
               <div class="text-gray-600 text-sm">
                    Hiển thị <span class="font-semibold">{{ $products->firstItem() }}</span> - 
                    <span class="font-semibold">{{ $products->lastItem() }}</span> 
                    trong <span class="font-semibold">{{ $products->total() }}</span> kết quả
               </div>
               
               <form action="{{ route('products.search') }}" method="GET" class="flex items-center gap-2">
                    <input type="hidden" name="q" value="{{ $keyword }}">
                    
                    <label class="text-sm text-gray-600">Sắp xếp:</label>
                    <select name="sort" 
                         onchange="this.form.submit()" 
                         class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                         <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Liên quan nhất</option>
                         <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                         <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                         <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                         <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Tên A-Z</option>
                    </select>
               </form>
          </div>
          
          <!-- Products Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
                              
                              <!-- Highlight search keyword -->
                              <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                   <span class="text-white text-sm">
                                        <i class="fas fa-search mr-1"></i> 
                                        Xem chi tiết
                                   </span>
                              </div>
                         </div>
                         
                         <div class="p-4">
                              <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 h-12">
                                   {!! preg_replace('/(' . preg_quote($keyword, '/') . ')/i', '<mark class="bg-yellow-200">$1</mark>', $product->product_name) !!}
                              </h3>
                              
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
               {{ $products->appends(['q' => $keyword, 'sort' => request('sort')])->links() }}
          </div>
          
     @else
        <!-- No Results -->
          <div class="bg-white rounded-lg shadow-md p-12 text-center">
               <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
               <h2 class="text-2xl font-bold text-gray-800 mb-2">Không tìm thấy kết quả</h2>
               <p class="text-gray-600 mb-6">
                    Không tìm thấy sản phẩm nào phù hợp với từ khóa "<span class="font-semibold">{{ $keyword }}</span>"
               </p>
               
               <!-- Search Suggestions -->
               <div class="max-w-xl mx-auto mb-8">
                    <h3 class="text-lg font-semibold mb-4">Gợi ý tìm kiếm:</h3>
                    <ul class="text-left space-y-2 text-gray-600">
                         <li><i class="fas fa-check text-green-600 mr-2"></i> Kiểm tra chính tả từ khóa</li>
                         <li><i class="fas fa-check text-green-600 mr-2"></i> Thử sử dụng từ khóa phổ biến hơn</li>
                         <li><i class="fas fa-check text-green-600 mr-2"></i> Thử sử dụng từ khóa ngắn gọn hơn</li>
                         <li><i class="fas fa-check text-green-600 mr-2"></i> Tìm kiếm theo danh mục sản phẩm</li>
                    </ul>
               </div>
               
               <!-- Popular Keywords -->
               <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Từ khóa phổ biến:</h3>
                    <div class="flex flex-wrap justify-center gap-2">
                         @php
                         $popularKeywords = ['Áo thun', 'Quần jean', 'Váy', 'Áo sơ mi', 'Giày thể thao', 'Túi xách', 'Áo khoác', 'Đầm'];
                         @endphp
                         @foreach($popularKeywords as $popularKeyword)
                         <a href="{{ route('products.search', ['q' => $popularKeyword]) }}" 
                              class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-blue-600 hover:text-white transition">
                              {{ $popularKeyword }}
                         </a>
                         @endforeach
                    </div>
               </div>
               
               <!-- Browse Categories -->
               <div>
                    <h3 class="text-lg font-semibold mb-4">Hoặc khám phá theo danh mục:</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                         @php
                         $categories = \App\Models\Category::withCount('products')->take(8)->get();
                         @endphp
                         @foreach($categories as $category)
                         <a href="{{ route('products.category', $category->id) }}" 
                              class="p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:border-blue-600 border-2 border-transparent transition">
                              <div class="text-center">
                                   <i class="fas fa-tshirt text-3xl text-blue-600 mb-2"></i>
                                   <div class="font-semibold">{{ $category->category_name }}</div>
                                   <div class="text-xs text-gray-500">{{ $category->products_count }} sản phẩm</div>
                              </div>
                         </a>
                         @endforeach
                    </div>
               </div>
               
               <div class="mt-8">
                    <a href="{{ route('products.index') }}" 
                    class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                         <i class="fas fa-arrow-left mr-2"></i>
                         Xem Tất Cả Sản Phẩm
                    </a>
               </div>
          </div>
    @endif
    
    <!-- Related Searches -->
     @if($products->count() > 0)
          <div class="mt-12 bg-gray-50 rounded-lg p-6">
               <h3 class="text-lg font-semibold mb-4">Tìm kiếm liên quan:</h3>
               <div class="flex flex-wrap gap-2">
                    @php
                         $relatedSearches = [
                         $keyword . ' nam',
                         $keyword . ' nữ',
                         $keyword . ' giá rẻ',
                         $keyword . ' cao cấp',
                         $keyword . ' đẹp',
                         $keyword . ' hot',
                         ];
                    @endphp
                    @foreach($relatedSearches as $relatedSearch)
                         <a href="{{ route('products.search', ['q' => $relatedSearch]) }}" 
                         class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:border-blue-600 hover:text-blue-600 transition text-sm">
                         <i class="fas fa-search mr-1 text-xs"></i>
                         {{ $relatedSearch }}
                         </a>
                    @endforeach
               </div>
          </div>
     @endif
</div>

@push('styles')
<style>
     mark {
        background-color: #fef08a;
        padding: 2px 4px;
        border-radius: 2px;
        font-weight: 600;
     }
</style>
@endpush
@endsection