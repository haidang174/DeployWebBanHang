@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Sản Phẩm - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3 mb-4">
          <a href="{{ route('admin.products.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Chỉnh Sửa Sản Phẩm</h1>
               <p class="text-gray-600 mt-1">Cập nhật thông tin sản phẩm: {{ $product->product_name }}</p>
          </div>
     </div>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" x-data="productEditForm()">
     @csrf
     @method('PUT')
     
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
                              value="{{ old('product_name', $product->product_name) }}"
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
                              <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                   placeholder="Mô tả chi tiết về sản phẩm: chất liệu, kích thước, cách bảo quản...">{{ old('description', $product->description) }}</textarea>
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
                                   value="{{ old('base_price', $product->base_price) }}"
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
                    
                    <!-- Existing Images -->
                    <div class="mb-6">
                         <label class="block text-sm font-semibold text-gray-700 mb-3">
                         <i class="fas fa-image text-green-600 mr-2"></i>
                         Ảnh Hiện Tại
                         </label>
                         
                         @if($product->images->count() > 0)
                         <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
                              @foreach($product->images as $image)
                              <div class="relative group" x-data="{ deleting: false }">
                                   <img src="{{ asset('storage/' . $image->image_url) }}" 
                                        alt="{{ $product->product_name }}"
                                        class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                   
                                   <!-- Main Image Badge -->
                                   @if($image->is_main)
                                   <div class="absolute top-2 left-2">
                                        <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full font-semibold">
                                             Chính
                                        </span>
                                   </div>
                                   @endif
                                   
                                   <!-- Delete Button -->
                                   <button type="button"
                                             @click="if(confirm('Xóa ảnh này?')) { 
                                                  deleting = true; 
                                                  deleteExistingImage({{ $image->id }}) 
                                             }"
                                             :disabled="deleting"
                                             class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition disabled:opacity-50">
                                        <i class="fas fa-times" x-show="!deleting"></i>
                                        <i class="fas fa-spinner fa-spin" x-show="deleting"></i>
                                   </button>
                                   
                                   <!-- Set Main Image Button -->
                                   @if(!$image->is_main)
                                   <button type="button"
                                             @click="setMainImage({{ $image->id }})"
                                             class="absolute bottom-2 left-2 bg-green-600 text-white px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition">
                                        Đặt làm chính
                                   </button>
                                   @endif
                              </div>
                              @endforeach
                         </div>
                         @else
                         <p class="text-gray-500 text-sm mb-4">
                              <i class="fas fa-info-circle mr-1"></i>
                              Chưa có ảnh nào
                         </p>
                         @endif
                    </div>
                    
                    <!-- Upload New Images -->
                    <div class="mb-4">
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-upload text-blue-600 mr-2"></i>
                         Thêm Ảnh Mới (Tối đa 5 ảnh)
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
                    
                    <!-- New Images Preview -->
                    <div x-show="newImages.length > 0" class="mt-4">
                         <label class="block text-sm font-semibold text-gray-700 mb-3">
                         Ảnh Mới (<span x-text="newImages.length"></span> ảnh)
                         </label>
                         <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                         <template x-for="(image, index) in newImages" :key="index">
                              <div class="relative group">
                                   <img :src="image.preview" 
                                        :alt="`Preview ${index + 1}`"
                                        class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                   
                                   <!-- Main Image Badge -->
                                   <div class="absolute top-2 left-2">
                                        <label class="flex items-center cursor-pointer">
                                             <input type="radio" 
                                                  name="new_main_image_index" 
                                                  :value="index"
                                                  class="mr-1">
                                             <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-full font-semibold">
                                             Chính
                                             </span>
                                        </label>
                                   </div>
                                   
                                   <!-- Remove Button -->
                                   <button type="button"
                                             @click="removeNewImage(index)"
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
                         <template x-for="(attribute, index) in attributes" :key="attribute.id || 'new_' + index">
                         <div class="p-4 border-2 border-gray-200 rounded-lg relative">
                              <!-- Hidden ID field for existing attributes - ALWAYS RENDER -->
                              <template x-if="attribute.id">
                                   <input type="hidden" 
                                        :name="'attributes[' + index + '][id]'" 
                                        :value="attribute.id">
                              </template>
                              
                              <!-- Delete indicator - ALWAYS RENDER if deleted -->
                              <template x-if="attribute.deleted">
                                   <input type="hidden" 
                                        :name="'attributes[' + index + '][deleted]'" 
                                        value="1">
                              </template>
                              
                              <!-- Remove Button -->
                              <button type="button" 
                                        @click="removeAttribute(index)"
                                        class="absolute top-2 right-2 text-red-600 hover:text-red-800">
                                   <i class="fas fa-times-circle"></i>
                              </button>
                              
                              <div class="grid grid-cols-1 md:grid-cols-4 gap-4" 
                                   :class="{ 'opacity-50': attribute.deleted }"
                                   x-show="!attribute.deleted">
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
                              
                              <div x-show="attribute.deleted" class="mt-2">
                                   <span class="text-red-600 text-sm font-semibold">
                                        <i class="fas fa-trash mr-1"></i>
                                        Sẽ bị xóa khi lưu
                                   </span>
                                   <button type="button" 
                                             @click="attribute.deleted = false"
                                             class="ml-2 text-blue-600 text-sm hover:underline">
                                        Hoàn tác
                                   </button>
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
                         Cập Nhật Sản Phẩm
                         </button>
                         
                         <a href="{{ route('admin.products.index') }}" 
                         class="block w-full bg-gray-200 text-gray-700 py-3 rounded-lg hover:bg-gray-300 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                         
                         <button type="button"
                              onclick="if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) { document.getElementById('delete-form').submit(); }"
                              class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition font-semibold flex items-center justify-center gap-2">
                         <i class="fas fa-trash"></i>
                         Xóa Sản Phẩm
                         </button>
                    </div>
               </div>
               
               <!-- Product Info -->
               <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <h3 class="font-bold mb-4 flex items-center">
                         <i class="fas fa-info-circle mr-2"></i>
                         Thông Tin Sản Phẩm
                    </h3>
                    
                    <ul class="space-y-2 text-sm">
                         <li class="flex justify-between">
                         <span>ID:</span>
                         <span class="font-semibold">{{ $product->id }}</span>
                         </li>
                         <li class="flex justify-between">
                         <span>Tạo lúc:</span>
                         <span class="font-semibold">{{ $product->created_at->format('d/m/Y') }}</span>
                         </li>
                         <li class="flex justify-between">
                         <span>Cập nhật:</span>
                         <span class="font-semibold">{{ $product->updated_at->format('d/m/Y') }}</span>
                         </li>
                         <li class="flex justify-between">
                         <span>Số ảnh:</span>
                         <span class="font-semibold">{{ $product->images->count() }}</span>
                         </li>
                         <li class="flex justify-between">
                         <span>Số phân loại:</span>
                         <span class="font-semibold">{{ $product->attributes->count() }}</span>
                         </li>
                    </ul>
               </div>
          </div>
     </div>
</form>

<!-- Delete Form (Hidden) -->
<form id="delete-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
     @csrf
     @method('DELETE')
</form>

@push('scripts')
<script>
// Data từ server
const productAttributesData = {!! json_encode($product->attributes->map(function($attr) {
     return [
          'id' => $attr->id,
          'size' => $attr->size,
          'color' => $attr->color,
          'price' => $attr->price,
          'quantity' => $attr->quantity,
          'deleted' => false
     ];
})->values()) !!};

function productEditForm() {
     return {
          newImages: [],
          newImageFiles: [],
          attributes: productAttributesData,
          
          handleImageUpload(event) {
               const files = Array.from(event.target.files);
               const currentTotal = {{ $product->images->count() }} + this.newImages.length;
               
               if (currentTotal + files.length > 5) {
                    alert('Tổng số ảnh không được vượt quá 5!');
                    event.target.value = '';
                    return;
               }
               
               this.newImages = [];
               this.newImageFiles = [];
               
               files.forEach((file) => {
                    if (file.size > 2 * 1024 * 1024) {
                         alert(`File ${file.name} vượt quá 2MB!`);
                         return;
                    }
                    
                    this.newImageFiles.push(file);
                    
                    const reader = new FileReader();
                    reader.onload = (e) => {
                         this.newImages.push({
                              preview: e.target.result,
                              name: file.name
                         });
                    };
                    reader.readAsDataURL(file);
               });
          },
          
          removeNewImage(index) {
               this.newImages.splice(index, 1);
               this.newImageFiles.splice(index, 1);
               this.updateFileInput();
          },
          
          updateFileInput() {
               const input = document.querySelector('input[name="images[]"]');
               const dt = new DataTransfer();
               
               this.newImageFiles.forEach(file => {
                    dt.items.add(file);
               });
               
               input.files = dt.files;
          },
          
          async deleteExistingImage(imageId) {
               try {
                    const response = await fetch(`/admin/products/image/${imageId}`, {
                         method: 'DELETE',
                         headers: {
                              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                              'Accept': 'application/json',
                         }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                         location.reload();
                    } else {
                         alert(data.message || 'Có lỗi xảy ra khi xóa ảnh!');
                    }
               } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra!');
               }
          },
          
          async setMainImage(imageId) {
               try {
                    const response = await fetch(`/admin/products/set-main-image/${imageId}`, {
                         method: 'POST',
                         headers: {
                              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                              'Accept': 'application/json',
                         }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                         location.reload();
                    } else {
                         alert(data.message || 'Có lỗi xảy ra!');
                    }
               } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra!');
               }
          },
          
          addAttribute() {
               this.attributes.push({
                    id: null,
                    size: '',
                    color: '',
                    price: '',
                    quantity: '',
                    deleted: false
               });
          },
          
          removeAttribute(index) {
               if (this.attributes[index].id) {
                    // Mark for deletion if it's existing attribute
                    this.attributes[index].deleted = true;
               } else {
                    // Remove directly if it's new attribute
                    this.attributes.splice(index, 1);
               }
          }
     }
}
</script>
@endpush
@endsection