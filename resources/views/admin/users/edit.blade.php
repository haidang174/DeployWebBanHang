@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Người Dùng - Admin')

@section('content')
<div class="mb-6">
     <div class="flex items-center gap-3">
          <a href="{{ route('admin.users.index') }}" 
               class="text-gray-600 hover:text-gray-900 transition">
               <i class="fas fa-arrow-left text-xl"></i>
          </a>
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Chỉnh Sửa Người Dùng</h1>
               <p class="text-gray-600 mt-1">Cập nhật thông tin: <span class="font-semibold text-blue-600">{{ $user->name }}</span></p>
          </div>
     </div>
</div>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
     @csrf
     @method('PUT')
     
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
                              value="{{ old('name', $user->name) }}"
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
                              value="{{ old('email', $user->email) }}"
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
               
               <!-- Role -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-user-shield text-purple-600 mr-2"></i>
                         Vai Trò
                    </h2>
                    
                    <div class="space-y-4">
                         <label class="flex items-center p-4 border-2 {{ old('is_admin', $user->is_admin) ? 'border-purple-500 bg-purple-50' : 'border-gray-300' }} rounded-lg cursor-pointer hover:border-purple-500 transition">
                         <input type="checkbox" 
                              name="is_admin" 
                              value="1" 
                              {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
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
               
               <!-- Password -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-lock text-purple-600 mr-2"></i>
                         Đổi Mật Khẩu
                    </h2>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-4">
                         <div class="flex">
                         <div class="flex-shrink-0">
                              <i class="fas fa-info-circle text-yellow-600"></i>
                         </div>
                         <div class="ml-3">
                              <p class="text-sm text-yellow-700">
                                   Để trống nếu không muốn thay đổi mật khẩu. Chỉ nhập khi muốn đặt mật khẩu mới.
                              </p>
                         </div>
                         </div>
                    </div>
                    
                    <div class="space-y-4">
                         <!-- Password -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-key text-yellow-600 mr-1"></i>
                              Mật Khẩu Mới
                         </label>
                         <div class="relative">
                              <input type="password" 
                                   id="password"
                                   name="password" 
                                   placeholder="Để trống nếu không đổi (tối thiểu 8 ký tự)..."
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
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
                              Mật khẩu mới phải có ít nhất 8 ký tự
                         </p>
                         </div>
                         
                         <!-- Confirm Password -->
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                              <i class="fas fa-check-circle text-green-600 mr-1"></i>
                              Xác Nhận Mật Khẩu Mới
                         </label>
                         <div class="relative">
                              <input type="password" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   placeholder="Nhập lại mật khẩu mới..."
                                   class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
               
               <!-- Account Info -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                         <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                         Thông Tin Tài Khoản
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         <div class="p-4 bg-gray-50 rounded-lg">
                         <label class="text-sm font-semibold text-gray-600 block mb-1">
                              <i class="fas fa-calendar-plus text-green-600 mr-1"></i>
                              Ngày Tạo
                         </label>
                         <div class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</div>
                         </div>
                         
                         <div class="p-4 bg-gray-50 rounded-lg">
                         <label class="text-sm font-semibold text-gray-600 block mb-1">
                              <i class="fas fa-clock text-yellow-600 mr-1"></i>
                              Cập Nhật Lần Cuối
                         </label>
                         <div class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $user->updated_at->diffForHumans() }}</div>
                         </div>
                         
                         @if($user->email_verified_at)
                         <div class="p-4 bg-green-50 rounded-lg">
                         <label class="text-sm font-semibold text-gray-600 block mb-1">
                              <i class="fas fa-check-circle text-green-600 mr-1"></i>
                              Email Xác Thực
                         </label>
                         <div class="text-gray-900">{{ $user->email_verified_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-green-600 mt-1">Đã xác thực</div>
                         </div>
                         @else
                         <div class="p-4 bg-yellow-50 rounded-lg">
                         <label class="text-sm font-semibold text-gray-600 block mb-1">
                              <i class="fas fa-clock text-yellow-600 mr-1"></i>
                              Email Xác Thực
                         </label>
                         <div class="text-yellow-700 text-sm">Chưa xác thực email</div>
                         </div>
                         @endif
                         
                         @if($user->google_id)
                         <div class="p-4 bg-red-50 rounded-lg">
                         <label class="text-sm font-semibold text-gray-600 block mb-1">
                              <i class="fab fa-google text-red-600 mr-1"></i>
                              Đăng Nhập Google
                         </label>
                         <div class="text-gray-900 text-sm">Đã liên kết tài khoản Google</div>
                         <div class="text-xs text-gray-500 mt-1">ID: {{ $user->google_id }}</div>
                         </div>
                         @endif
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
                         <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                              alt="{{ $user->name }}"
                              class="w-20 h-20 mx-auto mb-3 rounded-full">
                         <div class="text-lg font-bold mb-1" id="previewName">{{ $user->name }}</div>
                         <div class="text-sm opacity-90" id="previewEmail">{{ $user->email }}</div>
                         </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                         <div class="flex justify-between">
                         <span class="opacity-90">Vai trò:</span>
                         <span class="font-semibold" id="previewRole">{{ $user->is_admin ? 'Quản trị viên' : 'Khách hàng' }}</span>
                         </div>
                         <div class="flex justify-between">
                         <span class="opacity-90">Trạng thái:</span>
                         <span class="font-semibold">Hoạt động</span>
                         </div>
                         <div class="flex justify-between">
                         <span class="opacity-90">Đơn hàng:</span>
                         <span class="font-semibold">{{ $user->orders()->count() }}</span>
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
                         
                         <a href="{{ route('admin.users.show', $user->id) }}" 
                         class="block w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-center">
                         <i class="fas fa-eye mr-2"></i>
                         Xem Chi Tiết
                         </a>
                         
                         <a href="{{ route('admin.users.index') }}" 
                         class="block w-full px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold text-center">
                         <i class="fas fa-times mr-2"></i>
                         Hủy Bỏ
                         </a>
                    </div>
               </div>
               
               <!-- Statistics -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-chart-bar text-purple-600 mr-2"></i>
                         Thống Kê
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                         <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Tổng đơn hàng:</span>
                         <span class="font-bold text-gray-900">{{ $user->orders()->count() }}</span>
                         </div>
                         
                         <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Đơn hoàn thành:</span>
                         <span class="font-bold text-gray-900">{{ $user->orders()->where('status', 'delivered')->count() }}</span>
                         </div>
                         
                         <div class="flex justify-between items-center">
                         <span class="text-gray-600">Tổng chi tiêu:</span>
                         <span class="font-bold text-gray-900">
                              {{ number_format($user->orders()->where('status', 'delivered')->sum('total_amount'), 0, ',', '.') }}đ
                         </span>
                         </div>
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
                         Để trống nếu không đổi
                         </li>
                    </ul>
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
          }
     });
     
     emailInput.addEventListener('input', function() {
          if (this.value) {
               previewEmail.textContent = this.value;
          }
     });
     
     // Update role preview
     if (isAdminCheckbox) {
          isAdminCheckbox.addEventListener('change', function() {
               if (this.checked) {
                    previewRole.textContent = 'Quản trị viên';
               } else {
                    previewRole.textContent = 'Khách hàng';
               }
          });
     }
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