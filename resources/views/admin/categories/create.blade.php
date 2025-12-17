@extends('layouts.admin')

@section('title', 'Thêm Danh Mục - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3 mb-4">
          <a href="{{ route('admin.categories.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Thêm Danh Mục Mới</h1>
               <p class="text-gray-600 mt-1">Tạo danh mục sản phẩm mới cho cửa hàng</p>
          </div>
     </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
     <!-- Form -->
     <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-6">
               <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <!-- Category Name -->
                    <div class="mb-6">
                         <label for="category_name" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-tag text-blue-600 mr-2"></i>
                         Tên Danh Mục *
                         </label>
                         <input type="text" 
                              id="category_name"
                              name="category_name" 
                              value="{{ old('category_name') }}"
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
                    
                    <!-- Character Counter -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                         <div class="flex items-start gap-3">
                         <i class="fas fa-lightbulb text-blue-600 text-xl mt-1"></i>
                         <div>
                              <h4 class="font-semibold text-gray-900 mb-2">Gợi Ý Đặt Tên Danh Mục</h4>
                              <ul class="space-y-1 text-sm text-gray-700">
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-600 mt-1"></i>
                                        <span>Ngắn gọn, dễ nhớ (tối đa 50 ký tự)</span>
                                   </li>
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-600 mt-1"></i>
                                        <span>Mô tả rõ loại sản phẩm trong danh mục</span>
                                   </li>
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-600 mt-1"></i>
                                        <span>Tránh dùng ký tự đặc biệt phức tạp</span>
                                   </li>
                                   <li class="flex items-start gap-2">
                                        <i class="fas fa-check text-green-600 mt-1"></i>
                                        <span>Nên dùng tiếng Việt có dấu để dễ đọc</span>
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
                         Lưu Danh Mục
                         </button>
                         
                         <a href="{{ route('admin.categories.index') }}" 
                         class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                    </div>
               </form>
          </div>
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
                    <div class="p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                         <div class="flex items-center gap-3">
                         <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                              <i class="fas fa-folder text-blue-600 text-xl"></i>
                         </div>
                         <div class="flex-1">
                              <div class="font-semibold text-gray-900" id="preview-name">
                                   [Tên danh mục sẽ hiển thị ở đây]
                              </div>
                              <div class="text-xs text-gray-500 mt-1">
                                   <i class="fas fa-box mr-1"></i>
                                   0 sản phẩm
                              </div>
                         </div>
                         </div>
                    </div>
                    
                    <div class="text-xs text-gray-500">
                         <i class="fas fa-info-circle mr-1"></i>
                         Đây là cách danh mục sẽ hiển thị trong hệ thống
                    </div>
               </div>
          </div>
          
          <!-- Quick Stats -->
          <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white mb-6">
               <h3 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    Thống Kê Danh Mục
               </h3>
               
               <div class="space-y-3">
                    <div class="flex justify-between items-center">
                         <span class="text-sm opacity-90">Tổng danh mục hiện tại:</span>
                         <span class="font-bold text-lg">{{ \App\Models\Category::count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                         <span class="text-sm opacity-90">Tổng sản phẩm:</span>
                         <span class="font-bold text-lg">{{ \App\Models\Product::count() }}</span>
                    </div>
               </div>
          </div>
          
          <!-- Examples -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-list-ul text-purple-600 mr-2"></i>
                    Ví Dụ Danh Mục
               </h3>
               
               <div class="space-y-2 text-sm">
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition cursor-pointer" 
                         onclick="document.getElementById('category_name').value = 'Áo Thun Nam'">
                         <i class="fas fa-folder text-gray-400 mr-2"></i>
                         Áo Thun Nam
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition cursor-pointer"
                         onclick="document.getElementById('category_name').value = 'Quần Jean Nữ'">
                         <i class="fas fa-folder text-gray-400 mr-2"></i>
                         Quần Jean Nữ
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition cursor-pointer"
                         onclick="document.getElementById('category_name').value = 'Giày Thể Thao'">
                         <i class="fas fa-folder text-gray-400 mr-2"></i>
                         Giày Thể Thao
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition cursor-pointer"
                         onclick="document.getElementById('category_name').value = 'Túi Xách'">
                         <i class="fas fa-folder text-gray-400 mr-2"></i>
                         Túi Xách
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition cursor-pointer"
                         onclick="document.getElementById('category_name').value = 'Phụ Kiện Thời Trang'">
                         <i class="fas fa-folder text-gray-400 mr-2"></i>
                         Phụ Kiện Thời Trang
                    </div>
               </div>
               
               <p class="text-xs text-gray-500 mt-3">
                    <i class="fas fa-mouse-pointer mr-1"></i>
                    Click vào ví dụ để điền nhanh
               </p>
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
               previewElement.classList.remove('text-gray-400');
               previewElement.classList.add('text-gray-900');
          } else {
               previewElement.textContent = '[Tên danh mục sẽ hiển thị ở đây]';
               previewElement.classList.remove('text-gray-900');
               previewElement.classList.add('text-gray-400');
          }
     });
     
     // Character counter
     const input = document.getElementById('category_name');
     const maxLength = 255;
     
     input.addEventListener('input', function(e) {
          const length = e.target.value.length;
          
          // You can add character counter display here if needed
          if (length > maxLength - 50) {
               console.log('Warning: Approaching character limit');
          }
     });
</script>
@endpush
@endsection