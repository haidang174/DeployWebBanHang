@extends('layouts.admin')

@section('title', 'Quản Lý Danh Mục - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Quản Lý Danh Mục</h1>
               <p class="text-gray-600 mt-1">Quản lý danh mục sản phẩm của cửa hàng</p>
          </div>
          <a href="{{ route('admin.categories.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg">
               <i class="fas fa-plus mr-2"></i>
               Thêm Danh Mục
          </a>
     </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Danh Mục</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $categories->total() }}</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-list text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
     
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Sản Phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $categories->sum('products_count') }}</h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
     
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Trung Bình</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ $categories->total() > 0 ? number_format($categories->sum('products_count') / $categories->total(), 1) : 0 }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">sản phẩm/danh mục</p>
               </div>
               <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chart-bar text-2xl text-purple-600"></i>
               </div>
          </div>
     </div>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
     <!-- Table Header -->
     <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
               <h2 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-table mr-2 text-blue-600"></i>
                    Danh Sách Danh Mục
               </h2>
               
               <!-- Search & Filter -->
               <div class="flex gap-2 w-full md:w-auto">
                    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2 flex-1 md:flex-initial">
                         <input type="text" 
                              name="search" 
                              value="{{ request('search') }}"
                              placeholder="Tìm kiếm danh mục..." 
                              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full md:w-64">
                         <button type="submit" 
                              class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                         <i class="fas fa-search"></i>
                         </button>
                         @if(request('search'))
                         <a href="{{ route('admin.categories.index') }}" 
                              class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                              <i class="fas fa-times"></i>
                         </a>
                         @endif
                    </form>
               </div>
          </div>
     </div>
    
     <!-- Table -->
     @if($categories->count() > 0)
          <div class="overflow-x-auto">
               <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                         <tr>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              #
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Tên Danh Mục
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Số Sản Phẩm
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Ngày Tạo
                         </th>
                         <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Thao Tác
                         </th>
                         </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                         @foreach($categories as $category)
                         <tr class="hover:bg-gray-50 transition">
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                   {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                              </td>
                              
                              <td class="px-6 py-4 whitespace-nowrap">
                                   <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                             <i class="fas fa-folder text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                             <a href="{{ route('admin.categories.show', $category->id) }}" 
                                             class="text-sm font-semibold text-gray-900 hover:text-blue-600">
                                             {{ $category->category_name }}
                                             </a>
                                        </div>
                                   </div>
                              </td>
                              
                              <td class="px-6 py-4 whitespace-nowrap">
                                   <div class="flex items-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->products_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                             <i class="fas fa-box mr-1"></i>
                                             {{ $category->products_count }} sản phẩm
                                        </span>
                                   </div>
                              </td>
                              
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                   <div>
                                        <i class="fas fa-calendar mr-1 text-gray-400"></i>
                                        {{ $category->created_at->format('d/m/Y') }}
                                   </div>
                                   <div class="text-xs text-gray-400 mt-1">
                                        {{ $category->created_at->diffForHumans() }}
                                   </div>
                              </td>
                              
                              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                   <div class="flex items-center justify-end gap-2">
                                        <!-- View -->
                                        <a href="{{ route('admin.categories.show', $category->id) }}" 
                                        class="text-blue-600 hover:text-blue-900 transition"
                                        title="Xem chi tiết">
                                             <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- Edit -->
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                        class="text-yellow-600 hover:text-yellow-900 transition"
                                        title="Chỉnh sửa">
                                             <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete -->
                                        @if($category->products_count == 0)
                                             <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?')">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" 
                                                       class="text-red-600 hover:text-red-900 transition"
                                                       title="Xóa">
                                                  <i class="fas fa-trash"></i>
                                             </button>
                                             </form>
                                        @else
                                             <button type="button" 
                                                  class="text-gray-400 cursor-not-allowed"
                                                  title="Không thể xóa danh mục có sản phẩm"
                                                  disabled>
                                             <i class="fas fa-trash"></i>
                                             </button>
                                        @endif
                                   </div>
                              </td>
                         </tr>
                         @endforeach
                    </tbody>
               </table>
          </div>
          
          <!-- Pagination -->
          <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
               {{ $categories->links() }}
          </div>
     @else
          <!-- Empty State -->
          <div class="text-center py-12">
               <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                    <i class="fas fa-folder-open text-6xl text-gray-400"></i>
               </div>
               <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    @if(request('search'))
                         Không Tìm Thấy Kết Quả
                    @else
                         Chưa Có Danh Mục Nào
                    @endif
               </h3>
               <p class="text-gray-600 mb-6">
                    @if(request('search'))
                         Không tìm thấy danh mục nào phù hợp với từ khóa "{{ request('search') }}"
                    @else
                         Hãy tạo danh mục đầu tiên để bắt đầu quản lý sản phẩm
                    @endif
               </p>
               
               @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}" 
                    class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-semibold">
                         <i class="fas fa-times mr-2"></i>
                         Xóa Tìm Kiếm
                    </a>
               @else
                    <a href="{{ route('admin.categories.create') }}" 
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-plus mr-2"></i>
                         Tạo Danh Mục Đầu Tiên
                    </a>
               @endif
          </div>
    @endif
</div>

<!-- Quick Stats -->
@if($categories->count() > 0)
     <div class="mt-6 bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
          <div class="flex items-start gap-4">
               <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-2xl text-blue-600"></i>
               </div>
               <div class="flex-1">
                    <h3 class="font-bold text-gray-900 mb-2">
                         <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                         Mẹo Quản Lý Danh Mục
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Tạo danh mục rõ ràng, dễ hiểu giúp khách hàng tìm kiếm sản phẩm nhanh chóng</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Không thể xóa danh mục đã có sản phẩm - cần chuyển sản phẩm sang danh mục khác trước</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check-circle text-green-600 mt-1"></i>
                         <span>Nên giới hạn số lượng danh mục từ 5-15 để dễ quản lý</span>
                         </li>
                    </ul>
               </div>
          </div>
     </div>
@endif
@endsection