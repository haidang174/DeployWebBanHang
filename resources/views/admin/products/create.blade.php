@extends('layouts.admin')

@section('title', 'Thêm Sản Phẩm - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3 mb-4">
          <a href="{{ route('admin.products.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Thêm Sản Phẩm Mới</h1>
               <p class="text-gray-600 mt-1">Tạo sản phẩm mới với đầy đủ thông tin</p>
          </div>
     </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" 
      x-data="productForm()" @submit="if(!validateForm()) { $event.preventDefault(); }">
     @csrf
     
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Main Content -->
          <div class="lg:col-span-2 space-y-6">
               <!-- Basic Information -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                         Thông Tin Cơ Bản
                    </h2>
                    
                    <!-- Product Name -->
                    <div class="mb-6">
                         <label for="product_name" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-tag text-blue-600 mr-2"></i>
                         Tên Sản Phẩm *
                         </label>
                         <input type="text" 
                              id="product_name"
                              name="product_name" 
                              value="{{ old('product_name') }}"
                              required
                              maxlength="191"
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('product_name') border-red-500 @enderror"
                              placeholder="Ví dụ: Áo Thun Nam Basic Cotton">
                         @error('product_name')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Category -->
                    <div class="mb-6">
                         <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-folder text-purple-600 mr-2"></i>
                         Danh Mục *
                         </label>
                         <select name="category_id" 
                              id="category_id"
                              required
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('category_id') border-red-500 @enderror">
                         <option value="">-- Chọn danh mục --</option>
                         @foreach($categories as $category)
                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                   {{ $category->category_name }}
                              </option>
                         @endforeach
                         </select>
                         @error('category_id')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                         <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-align-left text-green-600 mr-2"></i>
                         Mô Tả Sản Phẩm
                         </label>
                         <textarea name="description" 
                                   id="description"
                                   rows="5"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('description') border-red-500 @enderror"
                                   placeholder="Mô tả chi tiết về sản phẩm: chất liệu, kích thước, cách bảo quản...">{{ old('description') }}</textarea>
                         @error('description')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Base Price -->
                    <div class="mb-6">
                         <label for="base_price" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-dollar-sign text-green-600 mr-2"></i>
                         Giá Cơ Bản *
                         </label>
                         <div class="relative">
                         <input type="number" 
                                   id="base_price"
                                   name="base_price" 
                                   value="{{ old('base_price', 0) }}"
                                   required
                                   min="0"
                                   step="1000"
                                   class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('base_price') border-red-500 @enderror"
                                   placeholder="150000">
                         <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">đ</span>
                         </div>
                         <p class="text-xs text-gray-500 mt-2">
                         <i class="fas fa-info-circle mr-1"></i>
                         Giá hiển thị khi chưa chọn phân loại. Giá thực tế sẽ theo từng biến thể.
                         </p>
                         @error('base_price')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                    </div>
               </div>
               
               <!-- Product Images -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-images text-purple-600 mr-2"></i>
                         Hình Ảnh Sản Phẩm
                    </h2>
                    
                    <div class="mb-4">
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-upload text-blue-600 mr-2"></i>
                         Tải Lên Hình Ảnh (Tối đa 5 ảnh)
                         </label>
                         <input type="file" 
                              name="images[]" 
                              multiple
                              accept="image/*"
                              @change="handleImageUpload($event)"
                              class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:border-blue-500 transition">
                         <p class="text-xs text-gray-500 mt-2">
                         <i class="fas fa-info-circle mr-1"></i>
                         Chấp nhận: JPG, PNG, GIF. Kích thước tối đa: 2MB/ảnh
                         </p>
                    </div>
                    
                    <!-- Image Preview -->
                    <div x-show="images.length > 0" class="mt-4">
                         <label class="block text-sm font-semibold text-gray-700 mb-3">
                         Xem Trước (<span x-text="images.length"></span> ảnh)
                         </label>
                         <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                         <template x-for="(image, index) in images" :key="index">
                              <div class="relative group">
                                   <img :src="image.preview" 
                                        :alt="`Preview ${index + 1}`"
                                        class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                   
                                   <!-- Main Image Badge -->
                                   <div class="absolute top-2 left-2">
                                        <label class="flex items-center cursor-pointer">
                                             <input type="radio" 
                                                  name="main_image_index" 
                                                  :value="index"
                                                  :checked="index === 0"
                                                  class="mr-1">
                                             <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full font-semibold">
                                             Chính
                                             </span>
                                        </label>
                                   </div>
                                   
                                   <!-- Remove Button -->
                                   <button type="button"
                                             @click="removeImage(index)"
                                             class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition">
                                        <i class="fas fa-times"></i>
                                   </button>
                              </div>
                         </template>
                         </div>
                    </div>
               </div>
               
               <!-- Product Attributes (Variants) -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-palette text-yellow-600 mr-2"></i>
                         Phân Loại Sản Phẩm (Size, Màu sắc)
                    </h2>
                    
                    <div class="space-y-4">
                         <template x-for="(attribute, index) in attributes" :key="index">
                         <div class="p-4 border-2 border-gray-200 rounded-lg relative">
                              <!-- Remove Button -->
                              <button type="button" 
                                        @click="removeAttribute(index)"
                                        x-show="attributes.length > 1"
                                        class="absolute top-2 right-2 text-red-600 hover:text-red-800">
                                   <i class="fas fa-times-circle"></i>
                              </button>
                              
                              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                   <!-- Size -->
                                   <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                             Size
                                        </label>
                                        <input type="text" 
                                             :name="'attributes[' + index + '][size]'"
                                             x-model="attribute.size"
                                             placeholder="S, M, L, XL..."
                                             maxlength="50"
                                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                   </div>
                                   
                                   <!-- Color -->
                                   <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                             Màu sắc
                                        </label>
                                        <input type="text" 
                                             :name="'attributes[' + index + '][color]'"
                                             x-model="attribute.color"
                                             placeholder="Đen, Trắng..."
                                             maxlength="50"
                                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                   </div>
                                   
                                   <!-- Price -->
                                   <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                             Giá *
                                        </label>
                                        <input type="number" 
                                             :name="'attributes[' + index + '][price]'"
                                             x-model="attribute.price"
                                             required
                                             min="0"
                                             step="1000"
                                             placeholder="150000"
                                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                   </div>
                                   
                                   <!-- Quantity -->
                                   <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                             Số lượng *
                                        </label>
                                        <input type="number" 
                                             :name="'attributes[' + index + '][quantity]'"
                                             x-model="attribute.quantity"
                                             required
                                             min="0"
                                             placeholder="100"
                                             class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                   </div>
                              </div>
                         </div>
                         </template>
                    </div>
                    
                    <!-- Add Attribute Button -->
                    <button type="button"
                         @click="addAttribute()"
                         class="mt-4 w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-blue-500 hover:text-blue-600 transition font-semibold">
                         <i class="fas fa-plus mr-2"></i>
                         Thêm Phân Loại
                    </button>
               </div>
          </div>
          
          <!-- Sidebar -->
          <div class="lg:col-span-1 space-y-6">
               <!-- Actions -->
               <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-tasks text-blue-600 mr-2"></i>
                         Hành Động
                    </h3>
                    
                    <div class="space-y-3">
                         <button type="submit" 
                              class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg flex items-center justify-center gap-2">
                         <i class="fas fa-save"></i>
                         Lưu Sản Phẩm
                         </button>
                         
                         <a href="{{ route('admin.products.index') }}" 
                         class="block w-full bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                    </div>
               </div>
               
               <!-- Tips -->
               <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <h3 class="font-bold mb-4 flex items-center">
                         <i class="fas fa-lightbulb mr-2"></i>
                         Mẹo Tạo Sản Phẩm
                    </h3>
                    
                    <ul class="space-y-2 text-sm">
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check mt-1"></i>
                         <span>Đặt tên rõ ràng, có từ khóa để dễ tìm kiếm</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check mt-1"></i>
                         <span>Upload ảnh chất lượng cao, nhiều góc độ</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check mt-1"></i>
                         <span>Mô tả chi tiết về chất liệu, kích thước</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check mt-1"></i>
                         <span>Thêm đầy đủ size và màu sắc có sẵn</span>
                         </li>
                         <li class="flex items-start gap-2">
                         <i class="fas fa-check mt-1"></i>
                         <span>Kiểm tra kỹ giá và tồn kho trước khi lưu</span>
                         </li>
                    </ul>
               </div>
               
               <!-- Required Fields Info -->
               <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                         <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                         Trường Bắt Buộc
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-1">
                         <li>• Tên sản phẩm</li>
                         <li>• Danh mục</li>
                         <li>• Giá cơ bản</li>
                         <li>• Ít nhất 1 phân loại</li>
                         <li>• Giá & số lượng của phân loại</li>
                    </ul>
               </div>
          </div>
     </div>
</form>

@push('scripts')
<script>
function productForm() {
     return {
          images: [],
          imageFiles: [], // Lưu trữ file riêng
          attributes: [
               { size: '', color: '', price: '', quantity: '' }
          ],
          
          handleImageUpload(event) {
               const files = Array.from(event.target.files);
               
               if (files.length > 5) {
                    alert('Chỉ được tải lên tối đa 5 ảnh!');
                    event.target.value = '';
                    return;
               }
               
               // Reset arrays
               this.images = [];
               this.imageFiles = [];
               
               files.forEach((file) => {
                    if (file.size > 2 * 1024 * 1024) {
                         alert(`File ${file.name} vượt quá 2MB!`);
                         return;
                    }
                    
                    // Lưu file vào array
                    this.imageFiles.push(file);
                    
                    const reader = new FileReader();
                    reader.onload = (e) => {
                         this.images.push({
                              preview: e.target.result,
                              name: file.name
                         });
                    };
                    reader.readAsDataURL(file);
               });
          },
          
          removeImage(index) {
               this.images.splice(index, 1);
               this.imageFiles.splice(index, 1);
               
               // Tạo lại input file với các file còn lại
               this.updateFileInput();
          },
          
          updateFileInput() {
               const input = document.querySelector('input[name="images[]"]');
               const dt = new DataTransfer();
               
               this.imageFiles.forEach(file => {
                    dt.items.add(file);
               });
               
               input.files = dt.files;
          },
          
          addAttribute() {
               this.attributes.push({
                    size: '',
                    color: '',
                    price: '',
                    quantity: ''
               });
          },
          
          removeAttribute(index) {
               if (this.attributes.length > 1) {
                    this.attributes.splice(index, 1);
               }
          },
          
          // Validate trước khi submit
          validateForm() {
               // Kiểm tra có ít nhất 1 attribute với giá và số lượng
               const hasValidAttribute = this.attributes.some(attr => {
                    return attr.price && attr.quantity;
               });
               
               if (!hasValidAttribute) {
                    alert('Vui lòng nhập ít nhất 1 phân loại với giá và số lượng!');
                    return false;
               }
               
               return true;
          }
     }
}
</script>
@endpush
@endsection