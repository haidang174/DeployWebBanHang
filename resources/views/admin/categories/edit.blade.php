@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Danh Mục - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3 mb-4">
          <a href="{{ route('admin.categories.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Chỉnh Sửa Danh Mục</h1>
               <p class="text-gray-600 mt-1">Cập nhật thông tin danh mục "{{ $category->category_name }}"</p>
          </div>
     </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
     <!-- Form -->
     <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-6">
               <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Category Name -->
                    <div class="mb-6">
                         <label for="category_name" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-tag text-blue-600 mr-2"></i>
                         Tên Danh Mục *
                         </label>
                         <input type="text" 
                              id="category_name"
                              name="category_name" 
                              value="{{ old('category_name', $category->category_name) }}"
                              required
                              autofocus
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('category_name') border-red-500 @enderror"
                              placeholder="Ví dụ: Áo Nam, Quần Nữ, Giày Thể Thao...">
                         
                         @error('category_name')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @else
                         <p class="text-gray-500 text-sm mt-2">
                              <i class="fas fa-info-circle mr-1"></i>
                              Tên danh mục phải rõ ràng, dễ hiểu và không trùng lặp
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Change History -->
                    <div class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                         <div class="flex items-start gap-3">
                         <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1"></i>
                         <div>
                              <h4 class="font-semibold text-gray-900 mb-2">Lưu Ý Khi Thay Đổi Tên</h4>
                              <ul class="space-y-1 text-sm text-gray-700">
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-info-circle text-yellow-600 mt-1"></i>
                                        <span>Thay đổi tên danh mục sẽ ảnh hưởng đến tất cả sản phẩm trong danh mục này</span>
                                   </li>
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-info-circle text-yellow-600 mt-1"></i>
                                        <span>Khách hàng sẽ thấy tên mới khi tìm kiếm và xem sản phẩm</span>
                                   </li>
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-info-circle text-yellow-600 mt-1"></i>
                                        <span>Nên thông báo cho team nếu thay đổi tên danh mục quan trọng</span>
                                   </li>
                              </ul>
                         </div>
                         </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3">
                         <button type="submit" 
                              class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg flex items-center justify-center gap-2">
                         <i class="fas fa-save"></i>
                         Cập Nhật Danh Mục
                         </button>
                         
                         <a href="{{ route('admin.categories.show', $category->id) }}" 
                         class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                    </div>
               </form>
          </div>
          
          <!-- Danger Zone -->
          @if($category->products_count == 0)
               <div class="mt-6 bg-red-50 rounded-lg border-2 border-red-200 p-6">
                    <h3 class="font-bold text-red-900 mb-3 flex items-center">
                         <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                         Vùng Nguy Hiểm
                    </h3>
                    <p class="text-sm text-red-700 mb-4">
                         Xóa danh mục này sẽ không thể hoàn tác. Vui lòng chắc chắn trước khi thực hiện.
                    </p>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                         method="POST" 
                         onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA DANH MỤC NÀY?\n\nHành động này không thể hoàn tác!')">
                         @csrf
                         @method('DELETE')
                         <button type="submit" 
                              class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                         <i class="fas fa-trash-alt mr-2"></i>
                         Xóa Danh Mục Này
                         </button>
                    </form>
               </div>
          @else
               <div class="mt-6 bg-gray-50 rounded-lg border-2 border-gray-200 p-6">
                    <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                         <i class="fas fa-lock text-gray-600 mr-2"></i>
                         Không Thể Xóa
                    </h3>
                    <p class="text-sm text-gray-700 mb-4">
                         Danh mục này đang có <strong>{{ $category->products_count }} sản phẩm</strong> và không thể xóa. 
                         Bạn cần chuyển tất cả sản phẩm sang danh mục khác trước.
                    </p>
                    <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                         <i class="fas fa-box mr-2"></i>
                         Xem {{ $category->products_count }} Sản Phẩm
                    </a>
               </div>
          @endif
     </div>
    
     <!-- Sidebar -->
     <div class="lg:col-span-1">
          <!-- Preview -->
          <div class="bg-white rounded-lg shadow-md p-6 mb-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-eye text-blue-600 mr-2"></i>
                    Xem Trước
               </h3>
               
               <div class="space-y-4">
                    <!-- Before -->
                    <div>
                         <div class="text-xs text-gray-500 mb-2">TÊN CŨ:</div>
                         <div class="p-4 bg-gray-50 rounded-lg border-2 border-gray-300">
                         <div class="flex items-center gap-3">
                              <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-folder text-gray-500 text-xl"></i>
                              </div>
                              <div class="flex-1">
                                   <div class="font-semibold text-gray-600">
                                        {{ $category->category_name }}
                                   </div>
                                   <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-box mr-1"></i>
                                        {{ $category->products_count }} sản phẩm
                                   </div>
                              </div>
                         </div>
                         </div>
                    </div>
                    
                    <!-- Arrow -->
                    <div class="text-center">
                         <i class="fas fa-arrow-down text-2xl text-gray-400"></i>
                    </div>
                    
                    <!-- After -->
                    <div>
                         <div class="text-xs text-gray-500 mb-2">TÊN MỚI:</div>
                         <div class="p-4 bg-blue-50 rounded-lg border-2 border-blue-300">
                         <div class="flex items-center gap-3">
                              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-folder text-blue-600 text-xl"></i>
                              </div>
                              <div class="flex-1">
                                   <div class="font-semibold text-gray-900" id="preview-name">
                                        {{ $category->category_name }}
                                   </div>
                                   <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-box mr-1"></i>
                                        {{ $category->products_count }} sản phẩm
                                   </div>
                              </div>
                         </div>
                         </div>
                    </div>
                    
                    <div class="text-xs text-gray-500">
                         <i class="fas fa-info-circle mr-1"></i>
                         Xem trước tên danh mục sau khi cập nhật
                    </div>
               </div>
          </div>
          
          <!-- Category Info -->
          <div class="bg-white rounded-lg shadow-md p-6 mb-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Thông Tin Danh Mục
               </h3>
               
               <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                         <span class="text-gray-600">
                         <i class="fas fa-box text-green-600 mr-2"></i>
                         Số sản phẩm:
                         </span>
                         <span class="font-semibold text-gray-900">{{ $category->products_count }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                         <span class="text-gray-600">
                         <i class="fas fa-calendar-plus text-blue-600 mr-2"></i>
                         Ngày tạo:
                         </span>
                         <span class="font-semibold text-gray-900">{{ $category->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                         <span class="text-gray-600">
                         <i class="fas fa-clock text-yellow-600 mr-2"></i>
                         Đã tạo:
                         </span>
                         <span class="font-semibold text-gray-900">{{ $category->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                         <span class="text-gray-600">
                         <i class="fas fa-edit text-purple-600 mr-2"></i>
                         Cập nhật lần cuối:
                         </span>
                         <span class="font-semibold text-gray-900">{{ $category->updated_at->diffForHumans() }}</span>
                    </div>
               </div>
          </div>
          
          <!-- Quick Actions -->
          <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg shadow-md p-6 text-white">
               <h3 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-bolt mr-2"></i>
                    Thao Tác Nhanh
               </h3>
               
               <div class="space-y-2">
                    <a href="{{ route('admin.categories.show', $category->id) }}" 
                    class="block p-3 bg-white/20 hover:bg-white/30 rounded-lg transition text-sm">
                         <i class="fas fa-eye mr-2"></i>
                         Xem Chi Tiết
                    </a>
                    
                    <a href="{{ route('admin.products.index', ['category_id' => $category->id]) }}" 
                    class="block p-3 bg-white/20 hover:bg-white/30 rounded-lg transition text-sm">
                         <i class="fas fa-box mr-2"></i>
                         Xem Sản Phẩm ({{ $category->products_count }})
                    </a>
                    
                    <a href="{{ route('products.category', $category->id) }}" 
                    target="_blank"
                    class="block p-3 bg-white/20 hover:bg-white/30 rounded-lg transition text-sm">
                         <i class="fas fa-external-link-alt mr-2"></i>
                         Xem Ở Frontend
                    </a>
               </div>
          </div>
     </div>
</div>

@push('scripts')
<script>
     // Live preview
     document.getElementById('category_name').addEventListener('input', function(e) {
          const previewElement = document.getElementById('preview-name');
          const value = e.target.value.trim();
          
          if (value) {
               previewElement.textContent = value;
          } else {
               previewElement.textContent = '{{ $category->category_name }}';
          }
     });
</script>
@endpush
@endsection