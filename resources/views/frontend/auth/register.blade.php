@extends('layouts.app')

@section('title', 'Đăng Ký - Fashion Shop')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
     <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Logo/Header -->
          <div class="text-center mb-8">
               <a href="{{ route('home') }}" class="inline-block">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                         <i class="fas fa-tshirt text-3xl text-white"></i>
                    </div>
               </a>
               <h1 class="text-3xl font-bold text-gray-900 mb-2">Tạo Tài Khoản Mới</h1>
               <p class="text-gray-600">Tham gia cùng hàng nghìn khách hàng hài lòng</p>
          </div>
          
          <!-- Register Form -->
          <div class="bg-white rounded-2xl shadow-xl p-8">
               <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Name Input -->
                    <div>
                         <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-user text-blue-600 mr-2"></i>
                         Họ và Tên *
                         </label>
                         <input type="text" 
                              id="name"
                              name="name" 
                              value="{{ old('name') }}"
                              required
                              autofocus
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                              placeholder="Nguyễn Văn A">
                         @error('name')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Email Input -->
                    <div>
                         <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-envelope text-blue-600 mr-2"></i>
                         Email *
                         </label>
                         <input type="email" 
                              id="email"
                              name="email" 
                              value="{{ old('email') }}"
                              required
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                              placeholder="email@example.com">
                         @error('email')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Password Input -->
                    <div>
                         <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-lock text-blue-600 mr-2"></i>
                         Mật Khẩu *
                         </label>
                         <div class="relative" x-data="{ showPassword: false }">
                         <input :type="showPassword ? 'text' : 'password'" 
                                   id="password"
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                                   placeholder="Tối thiểu 8 ký tự">
                         <button type="button" 
                                   @click="showPassword = !showPassword"
                                   class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                              <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                         </button>
                         </div>
                         @error('password')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @else
                         <p class="text-xs text-gray-500 mt-2">
                              <i class="fas fa-info-circle mr-1"></i>
                              Mật khẩu phải có ít nhất 8 ký tự
                         </p>
                         @enderror
                    </div>
                    
                    <!-- Password Confirmation Input -->
                    <div>
                         <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-lock text-blue-600 mr-2"></i>
                         Xác Nhận Mật Khẩu *
                         </label>
                         <div class="relative" x-data="{ showPassword: false }">
                         <input :type="showPassword ? 'text' : 'password'" 
                                   id="password_confirmation"
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   placeholder="Nhập lại mật khẩu">
                         <button type="button" 
                                   @click="showPassword = !showPassword"
                                   class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                              <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                         </button>
                         </div>
                    </div>
                    
                    <!-- Terms & Conditions -->
                    <div>
                         <label class="flex items-start cursor-pointer">
                         <input type="checkbox" 
                                   name="terms" 
                                   required
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 mt-1">
                         <span class="ml-3 text-sm text-gray-600">
                              Tôi đồng ý với 
                              <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Điều khoản sử dụng</a> 
                              và 
                              <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Chính sách bảo mật</a>
                         </span>
                         </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                         class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                         <i class="fas fa-user-plus mr-2"></i>
                         Đăng Ký
                    </button>
               </form>
               
               <!-- Divider -->
               <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                         <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                         <span class="px-4 bg-white text-gray-500">Hoặc đăng ký với</span>
                    </div>
               </div>
               
               <!-- Social Register -->
               <div class="space-y-3">
                    <a href="{{ route('google.redirect') }}" 
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition font-semibold">
                         <svg class="w-5 h-5" viewBox="0 0 24 24">
                         <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                         <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                         <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                         <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                         </svg>
                         Đăng ký với Google
                    </a>
               </div>
               
               <!-- Login Link -->
               <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                         Đã có tài khoản? 
                         <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                         Đăng nhập ngay
                         </a>
                    </p>
               </div>
          </div>
          
          <!-- Password Requirements -->
          <div class="mt-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
               <h4 class="font-semibold text-sm text-gray-900 mb-3 flex items-center">
                    <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                    Yêu Cầu Mật Khẩu
               </h4>
               <ul class="space-y-2 text-xs text-gray-600">
                    <li class="flex items-center gap-2">
                         <i class="fas fa-check-circle text-green-600"></i>
                         Tối thiểu 8 ký tự
                    </li>
                    <li class="flex items-center gap-2">
                         <i class="fas fa-check-circle text-green-600"></i>
                         Khuyến khích sử dụng chữ hoa, chữ thường, số và ký tự đặc biệt
                    </li>
                    <li class="flex items-center gap-2">
                         <i class="fas fa-check-circle text-green-600"></i>
                         Không sử dụng mật khẩu quá đơn giản (123456, password, v.v.)
                    </li>
               </ul>
          </div>
          
          <!-- Benefits -->
          <div class="mt-6 bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 text-center">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                    Đặc Quyền Thành Viên
               </h3>
               <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                         <div class="w-12 h-12 mx-auto mb-2 bg-blue-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-shipping-fast text-xl text-blue-600"></i>
                         </div>
                         <h4 class="text-xs font-semibold text-gray-900 mb-1">Miễn Phí Ship</h4>
                         <p class="text-xs text-gray-600">Đơn từ 500k</p>
                    </div>
                    
                    <div class="text-center">
                         <div class="w-12 h-12 mx-auto mb-2 bg-green-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-gift text-xl text-green-600"></i>
                         </div>
                         <h4 class="text-xs font-semibold text-gray-900 mb-1">Voucher</h4>
                         <p class="text-xs text-gray-600">Giảm 10% đơn đầu</p>
                    </div>
                    
                    <div class="text-center">
                         <div class="w-12 h-12 mx-auto mb-2 bg-purple-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-crown text-xl text-purple-600"></i>
                         </div>
                         <h4 class="text-xs font-semibold text-gray-900 mb-1">Ưu Đãi</h4>
                         <p class="text-xs text-gray-600">Độc quyền VIP</p>
                    </div>
                    
                    <div class="text-center">
                         <div class="w-12 h-12 mx-auto mb-2 bg-yellow-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-bell text-xl text-yellow-600"></i>
                         </div>
                         <h4 class="text-xs font-semibold text-gray-900 mb-1">Thông Báo</h4>
                         <p class="text-xs text-gray-600">Sale sớm nhất</p>
                    </div>
               </div>
          </div>
          
          <!-- Trust Badges -->
          <div class="mt-6 grid grid-cols-3 gap-4">
               <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">100K+</div>
                    <div class="text-xs text-gray-600 mt-1">Khách Hàng</div>
               </div>
               <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">98%</div>
                    <div class="text-xs text-gray-600 mt-1">Hài Lòng</div>
               </div>
               <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600">4.8★</div>
                    <div class="text-xs text-gray-600 mt-1">Đánh Giá</div>
               </div>
          </div>
          
          <!-- Privacy Notice -->
          <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
               <div class="flex items-start gap-3">
                    <i class="fas fa-lock text-green-600 text-xl mt-1"></i>
                    <div>
                         <h4 class="font-semibold text-sm text-gray-900 mb-1">Bảo Mật Thông Tin</h4>
                         <p class="text-xs text-gray-600">
                         Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn theo tiêu chuẩn quốc tế. 
                         Dữ liệu được mã hóa và không chia sẻ với bên thứ ba.
                         </p>
                    </div>
               </div>
          </div>
          
          <!-- Guest Option -->
          <div class="mt-6 text-center">
               <p class="text-sm text-gray-500 mb-3">hoặc</p>
               <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại trang chủ
               </a>
          </div>
     </div>
</div>

@push('styles')
<style>
     input:focus {
          outline: none;
     }
     
     input::placeholder {
          opacity: 0.5;
     }
     
     /* Password strength indicator (optional) */
     .password-strength {
          height: 4px;
          background: #e5e7eb;
          border-radius: 2px;
          overflow: hidden;
          margin-top: 8px;
     }
     
     .password-strength-bar {
          height: 100%;
          transition: all 0.3s ease;
     }
     
     .strength-weak { 
          width: 33%;
          background: #ef4444;
     }
     
     .strength-medium { 
          width: 66%;
          background: #f59e0b;
     }
     
     .strength-strong { 
          width: 100%;
          background: #10b981;
     }
</style>
@endpush

@push('scripts')
<script>
     // Optional: Password strength indicator
     document.addEventListener('DOMContentLoaded', function() {
          const passwordInput = document.getElementById('password');
          
          if (passwordInput) {
               passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    
                    if (password.length >= 8) strength++;
                    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                    if (password.match(/\d/)) strength++;
                    if (password.match(/[^a-zA-Z\d]/)) strength++;
                    
                    // You can add visual feedback here
                    console.log('Password strength:', strength);
               });
          }
     });
</script>
@endpush
@endsection