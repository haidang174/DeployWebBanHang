@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Mã Giảm Giá - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3">
          <a href="{{ route('admin.coupons.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Chỉnh Sửa Mã Giảm Giá</h1>
               <p class="text-gray-600 mt-1">Cập nhật thông tin mã: <span class="font-semibold text-blue-600">{{ $coupon->code }}</span></p>
          </div>
     </div>
</div>

<form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="space-y-6">
     @csrf
     @method('PUT')
     
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Main Form -->
          <div class="lg:col-span-2 space-y-6">
               <!-- Basic Info -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                         Thông Tin Cơ Bản
                    </h2>
                    
                    <div class="space-y-4">
                         <!-- Code -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-tag text-blue-600 mr-1"></i>
                              Mã Giảm Giá <span class="text-red-500">*</span>
                         </label>
                         <input type="text" 
                              name="code" 
                              value="{{ old('code', $coupon->code) }}"
                              placeholder="Ví dụ: SUMMER2024, NEWUSER, DISCOUNT50..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                              required>
                         @error('code')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Mã phải là duy nhất, viết hoa, không dấu, không khoảng trắng
                         </p>
                         </div>
                         
                         <!-- Type -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-percent text-green-600 mr-1"></i>
                              Loại Giảm Giá <span class="text-red-500">*</span>
                         </label>
                         <div class="grid grid-cols-2 gap-4">
                              <label class="relative flex items-center p-4 border-2 {{ old('type', $coupon->type) == 'percentage' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} rounded-lg cursor-pointer hover:border-blue-500 transition">
                                   <input type="radio" 
                                        name="type" 
                                        value="percentage" 
                                        {{ old('type', $coupon->type) == 'percentage' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600"
                                        required>
                                   <div class="ml-3">
                                        <div class="font-semibold text-gray-900">Phần Trăm (%)</div>
                                        <div class="text-xs text-gray-500">Giảm theo % giá trị đơn hàng</div>
                                   </div>
                              </label>
                              
                              <label class="relative flex items-center p-4 border-2 {{ old('type', $coupon->type) == 'fixed' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} rounded-lg cursor-pointer hover:border-blue-500 transition">
                                   <input type="radio" 
                                        name="type" 
                                        value="fixed" 
                                        {{ old('type', $coupon->type) == 'fixed' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600">
                                   <div class="ml-3">
                                        <div class="font-semibold text-gray-900">Cố Định (đ)</div>
                                        <div class="text-xs text-gray-500">Giảm một số tiền cố định</div>
                                   </div>
                              </label>
                         </div>
                         @error('type')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         </div>
                         
                         <!-- Value -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-dollar-sign text-yellow-600 mr-1"></i>
                              Giá Trị Giảm <span class="text-red-500">*</span>
                         </label>
                         <div class="relative">
                              <input type="number" 
                                   name="value" 
                                   value="{{ old('value', $coupon->value) }}"
                                   placeholder="Nhập giá trị..."
                                   step="0.01"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('value') border-red-500 @enderror"
                                   required>
                              <span class="absolute right-3 top-2 text-gray-500" id="valueUnit">{{ $coupon->type == 'percentage' ? '%' : 'đ' }}</span>
                         </div>
                         @error('value')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              <span id="valueHelp">{{ $coupon->type == 'percentage' ? 'Phần trăm giảm giá (0-100%)' : 'Số tiền giảm cố định' }}</span>
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Conditions -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-sliders-h text-purple-600 mr-2"></i>
                         Điều Kiện Áp Dụng
                    </h2>
                    
                    <div class="space-y-4">
                         <!-- Min Order Amount -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-shopping-cart text-blue-600 mr-1"></i>
                              Giá Trị Đơn Hàng Tối Thiểu
                         </label>
                         <div class="relative">
                              <input type="number" 
                                   name="min_order_amount" 
                                   value="{{ old('min_order_amount', $coupon->min_order_amount) }}"
                                   placeholder="0"
                                   step="1000"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_order_amount') border-red-500 @enderror">
                              <span class="absolute right-3 top-2 text-gray-500">đ</span>
                         </div>
                         @error('min_order_amount')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Để trống nếu không yêu cầu đơn hàng tối thiểu
                         </p>
                         </div>
                         
                         <!-- Max Discount Amount (for percentage only) -->
                         <div id="maxDiscountField" style="display: {{ old('type', $coupon->type) == 'percentage' ? 'block' : 'none' }};">
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-arrow-down text-orange-600 mr-1"></i>
                              Giảm Giá Tối Đa
                         </label>
                         <div class="relative">
                              <input type="number" 
                                   name="max_discount_amount" 
                                   value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}"
                                   placeholder="0"
                                   step="1000"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_discount_amount') border-red-500 @enderror">
                              <span class="absolute right-3 top-2 text-gray-500">đ</span>
                         </div>
                         @error('max_discount_amount')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Áp dụng cho loại phần trăm để giới hạn số tiền giảm tối đa
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Usage Limits -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-users text-green-600 mr-2"></i>
                         Giới Hạn Sử Dụng
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         <!-- Usage Limit -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-hashtag text-blue-600 mr-1"></i>
                              Tổng Số Lần Sử Dụng
                         </label>
                         <input type="number" 
                              name="usage_limit" 
                              value="{{ old('usage_limit', $coupon->usage_limit) }}"
                              placeholder="Không giới hạn"
                              min="1"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('usage_limit') border-red-500 @enderror">
                         @error('usage_limit')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-check-circle text-green-600 mr-1"></i>
                              Đã sử dụng: <strong>{{ $coupon->used_count }}</strong> lần
                         </p>
                         </div>
                         
                         <!-- Usage Per User -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-user text-purple-600 mr-1"></i>
                              Số Lần/Người Dùng
                         </label>
                         <input type="number" 
                              name="usage_per_user" 
                              value="{{ old('usage_per_user', $coupon->usage_per_user) }}"
                              placeholder="Không giới hạn"
                              min="1"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('usage_per_user') border-red-500 @enderror">
                         @error('usage_per_user')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Giới hạn số lần một người có thể dùng
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Validity Period -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                         Thời Gian Hiệu Lực
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         <!-- Start Date -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="far fa-calendar-plus text-green-600 mr-1"></i>
                              Ngày Bắt Đầu
                         </label>
                         <input type="date" 
                              name="start_date" 
                              value="{{ old('start_date', $coupon->start_date?->format('Y-m-d')) }}"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('start_date') border-red-500 @enderror">
                         @error('start_date')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Để trống để áp dụng ngay
                         </p>
                         </div>
                         
                         <!-- End Date -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="far fa-calendar-times text-red-600 mr-1"></i>
                              Ngày Kết Thúc
                         </label>
                         <input type="date" 
                              name="end_date" 
                              value="{{ old('end_date', $coupon->end_date?->format('Y-m-d')) }}"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('end_date') border-red-500 @enderror">
                         @error('end_date')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Để trống nếu không có ngày kết thúc
                         </p>
                         </div>
                    </div>
               </div>
          </div>
          
          <!-- Sidebar -->
          <div class="lg:col-span-1 space-y-6">
               <!-- Status -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-toggle-on text-green-600 mr-2"></i>
                         Trạng Thái
                    </h3>
                    
                    <label class="flex items-center p-4 border-2 {{ old('is_active', $coupon->is_active) ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} rounded-lg cursor-pointer hover:border-blue-500 transition">
                         <input type="checkbox" 
                         name="is_active" 
                         value="1" 
                         {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                         class="w-5 h-5 text-blue-600 rounded">
                         <div class="ml-3">
                         <div class="font-semibold text-gray-900">Kích Hoạt</div>
                         <div class="text-xs text-gray-500">Cho phép khách hàng sử dụng mã này</div>
                         </div>
                    </label>
                    
                    <!-- Current Status Badge -->
                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                         <div class="text-xs text-gray-600 mb-1">Trạng thái hiện tại:</div>
                         @if($coupon->isValid())
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                              <i class="fas fa-check-circle mr-1"></i>Hợp lệ
                         </span>
                         @else
                         @if(!$coupon->is_active)
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                   <i class="fas fa-power-off mr-1"></i>Đã tắt
                              </span>
                         @elseif($coupon->start_date && now()->lt($coupon->start_date))
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                   <i class="fas fa-clock mr-1"></i>Chưa bắt đầu
                              </span>
                         @elseif($coupon->end_date && now()->gt($coupon->end_date))
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                   <i class="fas fa-calendar-times mr-1"></i>Hết hạn
                              </span>
                         @elseif($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit)
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                   <i class="fas fa-ban mr-1"></i>Hết lượt
                              </span>
                         @endif
                         @endif
                    </div>
               </div>
               
               <!-- Preview Card -->
               <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <h3 class="font-bold mb-4 flex items-center">
                         <i class="fas fa-eye mr-2"></i>
                         Xem Trước Mã
                    </h3>
                    
                    <div class="bg-white/10 backdrop-blur rounded-lg p-4 mb-4">
                         <div class="text-center">
                         <div class="text-2xl font-bold mb-2" id="previewCode">{{ $coupon->code }}</div>
                         <div class="text-sm opacity-90" id="previewValue">
                              @if($coupon->type == 'percentage')
                                   Giảm {{ $coupon->value }}%
                              @else
                                   Giảm {{ number_format($coupon->value, 0, ',', '.') }}đ
                              @endif
                         </div>
                         </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                         <div class="flex justify-between">
                         <span class="opacity-90">Loại:</span>
                         <span class="font-semibold" id="previewType">{{ $coupon->type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</span>
                         </div>
                         <div class="flex justify-between" id="previewMinOrder" style="display: {{ $coupon->min_order_amount ? 'flex' : 'none' }};">
                         <span class="opacity-90">Đơn tối thiểu:</span>
                         <span class="font-semibold" id="previewMinOrderValue">{{ number_format($coupon->min_order_amount, 0, ',', '.') }}đ</span>
                         </div>
                         <div class="flex justify-between">
                         <span class="opacity-90">Đã sử dụng:</span>
                         <span class="font-semibold">{{ $coupon->used_count }} lần</span>
                         </div>
                    </div>
               </div>
               
               <!-- Actions -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-tasks text-yellow-600 mr-2"></i>
                         Hành Động
                    </h3>
                    
                    <div class="space-y-2">
                         <button type="submit" 
                         class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-save mr-2"></i>
                         Cập Nhật
                         </button>
                         
                         <a href="{{ route('admin.coupons.show', $coupon->id) }}" 
                         class="block w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-center">
                         <i class="fas fa-eye mr-2"></i>
                         Xem Chi Tiết
                         </a>
                         
                         <a href="{{ route('admin.coupons.index') }}" 
                         class="block w-full px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                    </div>
               </div>
               
               <!-- Usage Stats -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-chart-bar text-purple-600 mr-2"></i>
                         Thống Kê
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                         <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Đã sử dụng:</span>
                         <span class="font-bold text-gray-900">{{ $coupon->used_count }}</span>
                         </div>
                         
                         <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Giới hạn:</span>
                         <span class="font-bold text-gray-900">{{ $coupon->usage_limit ?? '∞' }}</span>
                         </div>
                         
                         <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Đơn hàng:</span>
                         <span class="font-bold text-gray-900">{{ $coupon->orders()->count() }}</span>
                         </div>
                         
                         @if($coupon->usage_limit)
                         <div>
                         <div class="flex justify-between text-xs mb-1">
                              <span class="text-gray-600">Tỷ lệ sử dụng:</span>
                              <span class="font-semibold">{{ round(($coupon->used_count / $coupon->usage_limit) * 100) }}%</span>
                         </div>
                         <div class="w-full bg-gray-200 rounded-full h-2">
                              <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($coupon->used_count / $coupon->usage_limit) * 100, 100) }}%"></div>
                         </div>
                         </div>
                         @endif
                    </div>
               </div>
          </div>
     </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
     const typeRadios = document.querySelectorAll('input[name="type"]');
     const valueInput = document.querySelector('input[name="value"]');
     const codeInput = document.querySelector('input[name="code"]');
     const minOrderInput = document.querySelector('input[name="min_order_amount"]');
     const maxDiscountField = document.getElementById('maxDiscountField');
     const valueUnit = document.getElementById('valueUnit');
     const valueHelp = document.getElementById('valueHelp');
     
     // Preview elements
     const previewCode = document.getElementById('previewCode');
     const previewValue = document.getElementById('previewValue');
     const previewType = document.getElementById('previewType');
     const previewMinOrder = document.getElementById('previewMinOrder');
     const previewMinOrderValue = document.getElementById('previewMinOrderValue');
     
     // Handle type change
     typeRadios.forEach(radio => {
          radio.addEventListener('change', function() {
               if (this.value === 'percentage') {
                    valueUnit.textContent = '%';
                    valueHelp.textContent = 'Phần trăm giảm giá (0-100%)';
                    maxDiscountField.style.display = 'block';
                    previewType.textContent = 'Phần trăm';
               } else {
                    valueUnit.textContent = 'đ';
                    valueHelp.textContent = 'Số tiền giảm cố định';
                    maxDiscountField.style.display = 'none';
                    previewType.textContent = 'Cố định';
               }
               updatePreview();
          });
     });
    
     // Update preview on input
     codeInput.addEventListener('input', updatePreview);
     valueInput.addEventListener('input', updatePreview);
     minOrderInput.addEventListener('input', updatePreview);
     
     function updatePreview() {
          // Update code
          if (codeInput.value) {
               previewCode.textContent = codeInput.value.toUpperCase();
          }
          
          // Update value
          const selectedType = document.querySelector('input[name="type"]:checked').value;
          if (valueInput.value) {
               if (selectedType === 'percentage') {
                    previewValue.textContent = `Giảm ${valueInput.value}%`;
               } else {
                    previewValue.textContent = `Giảm ${parseInt(valueInput.value).toLocaleString('vi-VN')}đ`;
               }
          }
          
          // Update min order
          if (minOrderInput.value && parseFloat(minOrderInput.value) > 0) {
               previewMinOrder.style.display = 'flex';
               previewMinOrderValue.textContent = parseInt(minOrderInput.value).toLocaleString('vi-VN') + 'đ';
          } else {
               previewMinOrder.style.display = 'none';
          }
     }
});
</script>
@endpush
@endsection