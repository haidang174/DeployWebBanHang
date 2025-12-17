@extends('layouts.admin')

@section('title', 'Thêm Người Dùng - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3">
          <a href="{{ route('admin.users.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Thêm Người Dùng Mới</h1>
               <p class="text-gray-600 mt-1">Tạo tài khoản người dùng mới trong hệ thống</p>
          </div>
     </div>
</div>

<form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
     @csrf
     
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Main Form -->
          <div class="lg:col-span-2 space-y-6">
               <!-- Basic Info -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-user text-blue-600 mr-2"></i>
                         Thông Tin Cơ Bản
                    </h2>
                    
                    <div class="space-y-4">
                         <!-- Name -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-user-circle text-blue-600 mr-1"></i>
                              Họ và Tên <span class="text-red-500">*</span>
                         </label>
                         <input type="text" 
                              name="name" 
                              value="{{ old('name') }}"
                              placeholder="Nhập họ và tên đầy đủ..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                              required>
                         @error('name')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         </div>
                         
                         <!-- Email -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-envelope text-green-600 mr-1"></i>
                              Email <span class="text-red-500">*</span>
                         </label>
                         <input type="email" 
                              name="email" 
                              value="{{ old('email') }}"
                              placeholder="example@email.com"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                              required>
                         @error('email')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Email phải là duy nhất trong hệ thống
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Password -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-lock text-purple-600 mr-2"></i>
                         Mật Khẩu
                    </h2>
                    
                    <div class="space-y-4">
                         <!-- Password -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-key text-yellow-600 mr-1"></i>
                              Mật Khẩu <span class="text-red-500">*</span>
                         </label>
                         <div class="relative">
                              <input type="password" 
                                   id="password"
                                   name="password" 
                                   placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)..."
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                   required>
                              <button type="button" 
                                   onclick="togglePassword('password')"
                                   class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                   <i class="fas fa-eye" id="password-icon"></i>
                              </button>
                         </div>
                         @error('password')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                         @enderror
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Mật khẩu phải có ít nhất 8 ký tự
                         </p>
                         </div>
                         
                         <!-- Confirm Password -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-check-circle text-green-600 mr-1"></i>
                              Xác Nhận Mật Khẩu <span class="text-red-500">*</span>
                         </label>
                         <div class="relative">
                              <input type="password" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   placeholder="Nhập lại mật khẩu..."
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                              <button type="button" 
                                   onclick="togglePassword('password_confirmation')"
                                   class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                   <i class="fas fa-eye" id="password_confirmation-icon"></i>
                              </button>
                         </div>
                         <p class="mt-1 text-xs text-gray-500">
                              <i class="fas fa-info-circle mr-1"></i>
                              Nhập lại mật khẩu để xác nhận
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Role -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-user-shield text-purple-600 mr-2"></i>
                         Vai Trò
                    </h2>
                    
                    <div class="space-y-4">
                         <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition">
                         <input type="checkbox" 
                              name="is_admin" 
                              value="1" 
                              {{ old('is_admin') ? 'checked' : '' }}
                              id="is_admin_checkbox"
                              class="w-5 h-5 text-purple-600 rounded">
                         <div class="ml-3">
                              <div class="font-semibold text-gray-900">Quản Trị Viên (Admin)</div>
                              <div class="text-xs text-gray-500">Cấp quyền quản trị toàn bộ hệ thống</div>
                         </div>
                         </label>
                         
                         <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded">
                         <div class="flex">
                              <div class="flex-shrink-0">
                                   <i class="fas fa-exclamation-triangle text-orange-600"></i>
                              </div>
                              <div class="ml-3">
                                   <h3 class="text-sm font-semibold text-orange-800 mb-1">Cảnh Báo</h3>
                                   <p class="text-xs text-orange-700">
                                        Admin có toàn quyền truy cập và quản lý hệ thống. Chỉ cấp quyền này cho người đáng tin cậy.
                                   </p>
                              </div>
                         </div>
                         </div>
                    </div>
               </div>
               
               <!-- Additional Info -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                         Thông Tin Bổ Sung
                    </h2>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                         <div class="flex">
                         <div class="flex-shrink-0">
                              <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                         </div>
                         <div class="ml-3">
                              <h3 class="text-sm font-semibold text-blue-800 mb-2">Lưu Ý</h3>
                              <ul class="text-xs text-blue-700 space-y-1">
                                   <li>• Email sẽ được sử dụng để đăng nhập vào hệ thống</li>
                                   <li>• Mật khẩu sẽ được mã hóa an toàn trước khi lưu</li>
                                   <li>• Người dùng có thể thay đổi thông tin sau khi đăng nhập</li>
                                   <li>• Mặc định tài khoản mới là khách hàng (không phải admin)</li>
                              </ul>
                         </div>
                         </div>
                    </div>
               </div>
          </div>
          
          <!-- Sidebar -->
          <div class="lg:col-span-1 space-y-6">
               <!-- Preview Card -->
               <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <h3 class="font-bold mb-4 flex items-center">
                         <i class="fas fa-user-circle mr-2"></i>
                         Xem Trước
                    </h3>
                    
                    <div class="bg-white/10 backdrop-blur rounded-lg p-4 mb-4">
                         <div class="text-center">
                         <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white/20 flex items-center justify-center">
                              <i class="fas fa-user text-4xl"></i>
                         </div>
                         <div class="text-lg font-bold mb-1" id="previewName">Tên người dùng</div>
                         <div class="text-sm opacity-90" id="previewEmail">email@example.com</div>
                         </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                         <div class="flex justify-between">
                         <span class="opacity-90">Vai trò:</span>
                         <span class="font-semibold" id="previewRole">Khách hàng</span>
                         </div>
                         <div class="flex justify-between">
                         <span class="opacity-90">Trạng thái:</span>
                         <span class="font-semibold">Hoạt động</span>
                         </div>
                         <div class="flex justify-between">
                         <span class="opacity-90">Email xác thực:</span>
                         <span class="font-semibold">Chưa xác thực</span>
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
                         Tạo Người Dùng
                         </button>
                         
                         <a href="{{ route('admin.users.index') }}" 
                         class="block w-full px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                    </div>
               </div>
               
               <!-- Password Requirements -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                         Yêu Cầu Mật Khẩu
                    </h3>
                    
                    <ul class="space-y-2 text-sm">
                         <li class="flex items-center text-gray-600">
                         <i class="fas fa-check-circle text-green-500 mr-2"></i>
                         Tối thiểu 8 ký tự
                         </li>
                         <li class="flex items-center text-gray-600">
                         <i class="fas fa-check-circle text-green-500 mr-2"></i>
                         Phải xác nhận khớp
                         </li>
                         <li class="flex items-center text-gray-600">
                         <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                         Nên kết hợp chữ, số, ký tự đặc biệt
                         </li>
                    </ul>
               </div>
               
               <!-- Tips -->
               <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <div class="flex">
                         <div class="flex-shrink-0">
                         <i class="fas fa-lightbulb text-yellow-600 text-xl"></i>
                         </div>
                         <div class="ml-3">
                         <h3 class="text-sm font-semibold text-yellow-800 mb-2">Gợi Ý</h3>
                         <ul class="text-xs text-yellow-700 space-y-1">
                              <li>• Kiểm tra kỹ email trước khi tạo</li>
                              <li>• Ghi chú mật khẩu để gửi cho người dùng</li>
                              <li>• Người dùng nên đổi mật khẩu sau lần đầu đăng nhập</li>
                         </ul>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
     const nameInput = document.querySelector('input[name="name"]');
     const emailInput = document.querySelector('input[name="email"]');
     const isAdminCheckbox = document.getElementById('is_admin_checkbox');
     const previewName = document.getElementById('previewName');
     const previewEmail = document.getElementById('previewEmail');
     const previewRole = document.getElementById('previewRole');
     
     // Update preview on input
     nameInput.addEventListener('input', function() {
          if (this.value) {
               previewName.textContent = this.value;
          } else {
               previewName.textContent = 'Tên người dùng';
          }
     });
     
     emailInput.addEventListener('input', function() {
          if (this.value) {
               previewEmail.textContent = this.value;
          } else {
               previewEmail.textContent = 'email@example.com';
          }
     });
     
     // Update role preview
     isAdminCheckbox.addEventListener('change', function() {
          if (this.checked) {
               previewRole.textContent = 'Quản trị viên';
               previewRole.classList.add('text-purple-200');
          } else {
               previewRole.textContent = 'Khách hàng';
               previewRole.classList.remove('text-purple-200');
          }
     });
});

function togglePassword(fieldId) {
     const field = document.getElementById(fieldId);
     const icon = document.getElementById(fieldId + '-icon');
     
     if (field.type === 'password') {
          field.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
     } else {
          field.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
     }
}
</script>
@endpush
@endsection