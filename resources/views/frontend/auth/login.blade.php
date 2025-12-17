@extends('layouts.app')

@section('title', 'Đăng Nhập - Fashion Shop')

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
               <h1 class="text-3xl font-bold text-gray-900 mb-2">Chào Mừng Trở Lại!</h1>
               <p class="text-gray-600">Đăng nhập để tiếp tục mua sắm</p>
          </div>
          
          <!-- Login Form -->
          <div class="bg-white rounded-2xl shadow-xl p-8">
               <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Email Input -->
                    <div>
                         <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-envelope text-blue-600 mr-2"></i>
                         Email
                         </label>
                         <input type="email" 
                              id="email"
                              name="email" 
                              value="{{ old('email') }}"
                              required
                              autofocus
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
                         Mật Khẩu
                         </label>
                         <div class="relative" x-data="{ showPassword: false }">
                         <input :type="showPassword ? 'text' : 'password'" 
                                   id="password"
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 pr-12 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                                   placeholder="••••••••">
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
                         @enderror
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                         <label class="flex items-center cursor-pointer">
                         <input type="checkbox" 
                                   name="remember" 
                                   {{ old('remember') ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                         <span class="ml-2 text-sm text-gray-600">Ghi nhớ đăng nhập</span>
                         </label>
                         
                         <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                         Quên mật khẩu?
                         </a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                         class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                         <i class="fas fa-sign-in-alt mr-2"></i>
                         Đăng Nhập
                    </button>
               </form>
               
               <!-- Divider -->
               <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                         <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                         <span class="px-4 bg-white text-gray-500">Hoặc đăng nhập với</span>
                    </div>
               </div>
               
               <!-- Social Login -->
               <div class="space-y-3">
                    <a href="{{ route('google.redirect') }}" 
                    class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition font-semibold">
                         <svg class="w-5 h-5" viewBox="0 0 24 24">
                         <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                         <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                         <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                         <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                         </svg>
                         Đăng nhập với Google
                    </a>
                    
                    <!-- Can add more social logins here -->
                    <!-- 
                    <button class="w-full flex items-center justify-center gap-3 px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition font-semibold">
                         <i class="fab fa-facebook text-blue-600 text-xl"></i>
                         Đăng nhập với Facebook
                    </button>
                    -->
               </div>
               
               <!-- Register Link -->
               <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                         Chưa có tài khoản? 
                         <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                         Đăng ký ngay
                         </a>
                    </p>
               </div>
          </div>
          
          <!-- Guest Actions -->
          <div class="mt-6 text-center">
               <p class="text-sm text-gray-500 mb-3">hoặc</p>
               <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Tiếp tục với tư cách khách
               </a>
          </div>
          
          <!-- Benefits -->
          <div class="mt-8 bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 text-center">
                    <i class="fas fa-gift text-blue-600 mr-2"></i>
                    Lợi Ích Khi Đăng Nhập
               </h3>
               <div class="space-y-3">
                    <div class="flex items-start gap-3">
                         <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-check text-blue-600"></i>
                         </div>
                         <div>
                         <h4 class="font-semibold text-sm text-gray-900">Quản Lý Đơn Hàng</h4>
                         <p class="text-xs text-gray-600">Theo dõi trạng thái đơn hàng dễ dàng</p>
                         </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                         <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-check text-green-600"></i>
                         </div>
                         <div>
                         <h4 class="font-semibold text-sm text-gray-900">Thanh Toán Nhanh</h4>
                         <p class="text-xs text-gray-600">Lưu thông tin giao hàng cho lần sau</p>
                         </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                         <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-check text-purple-600"></i>
                         </div>
                         <div>
                         <h4 class="font-semibold text-sm text-gray-900">Ưu Đãi Độc Quyền</h4>
                         <p class="text-xs text-gray-600">Nhận voucher và khuyến mãi đặc biệt</p>
                         </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                         <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-check text-yellow-600"></i>
                         </div>
                         <div>
                         <h4 class="font-semibold text-sm text-gray-900">Danh Sách Yêu Thích</h4>
                         <p class="text-xs text-gray-600">Lưu sản phẩm yêu thích để mua sau</p>
                         </div>
                    </div>
               </div>
          </div>
          
          <!-- Security Notice -->
          <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
               <div class="flex items-start gap-3">
                    <i class="fas fa-shield-alt text-blue-600 text-xl mt-1"></i>
                    <div>
                         <h4 class="font-semibold text-sm text-gray-900 mb-1">Bảo Mật & An Toàn</h4>
                         <p class="text-xs text-gray-600">
                         Thông tin của bạn được mã hóa và bảo vệ theo tiêu chuẩn quốc tế. 
                         Chúng tôi cam kết không chia sẻ dữ liệu cá nhân của bạn.
                         </p>
                    </div>
               </div>
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
</style>
@endpush
@endsection