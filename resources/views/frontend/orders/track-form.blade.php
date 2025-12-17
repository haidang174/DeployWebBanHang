@extends('layouts.app')

@section('title', 'Tra Cứu Đơn Hàng - Fashion Shop')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
     <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Header -->
          <div class="text-center mb-8">
               <div class="inline-block p-4 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-search-location text-4xl text-blue-600"></i>
               </div>
               <h1 class="text-4xl font-bold text-gray-900 mb-3">Tra Cứu Đơn Hàng</h1>
               <p class="text-lg text-gray-600">
                    Nhập thông tin để kiểm tra trạng thái đơn hàng của bạn
               </p>
          </div>
          
          <!-- Tracking Form -->
          <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
               <form action="{{ route('order.track.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Order Code Input -->
                    <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-barcode text-blue-600 mr-2"></i>
                         Mã Đơn Hàng *
                         </label>
                         <input type="text" 
                              name="order_code" 
                              value="{{ old('order_code') }}"
                              placeholder="Ví dụ: ORD65701E3A12B45" 
                              required
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-lg font-mono uppercase"
                              maxlength="20">
                         @error('order_code')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                         <p class="text-xs text-gray-500 mt-2">
                         <i class="fas fa-info-circle mr-1"></i>
                         Mã đơn hàng bắt đầu bằng "ORD" và có trong email xác nhận
                         </p>
                    </div>
                    
                    <!-- Email Input -->
                    <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-envelope text-blue-600 mr-2"></i>
                         Email Đặt Hàng *
                         </label>
                         <input type="email" 
                              name="email" 
                              value="{{ old('email') }}"
                              placeholder="email@example.com" 
                              required
                              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-lg">
                         @error('email')
                         <p class="text-red-600 text-sm mt-2">
                              <i class="fas fa-exclamation-circle mr-1"></i>
                              {{ $message }}
                         </p>
                         @enderror
                         <p class="text-xs text-gray-500 mt-2">
                         <i class="fas fa-info-circle mr-1"></i>
                         Email mà bạn đã sử dụng khi đặt hàng
                         </p>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                         class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                         <i class="fas fa-search mr-2"></i>
                         Tra Cứu Đơn Hàng
                    </button>
               </form>
          </div>
          
          <!-- Help Section -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
               <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start gap-4">
                         <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-question-circle text-2xl text-blue-600"></i>
                         </div>
                         <div>
                         <h3 class="font-semibold text-gray-900 mb-2">Không Tìm Thấy Mã?</h3>
                         <p class="text-sm text-gray-600">
                              Mã đơn hàng được gửi qua email sau khi bạn đặt hàng thành công. 
                              Kiểm tra cả hộp thư spam/junk.
                         </p>
                         </div>
                    </div>
               </div>
               
               <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start gap-4">
                         <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                         <i class="fas fa-user-circle text-2xl text-green-600"></i>
                         </div>
                         <div>
                         <h3 class="font-semibold text-gray-900 mb-2">Đã Có Tài Khoản?</h3>
                         <p class="text-sm text-gray-600 mb-2">
                              Đăng nhập để xem tất cả đơn hàng của bạn.
                         </p>
                         <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                              Đăng nhập ngay <i class="fas fa-arrow-right ml-1"></i>
                         </a>
                         </div>
                    </div>
               </div>
          </div>
          
          <!-- How to Find Order Code -->
          <div class="bg-white rounded-lg shadow-md p-8">
               <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                    Làm Sao Tìm Mã Đơn Hàng?
               </h2>
               
               <div class="space-y-6">
                    <div class="flex gap-4">
                         <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                         1
                         </div>
                         <div class="flex-1">
                         <h3 class="font-semibold text-gray-900 mb-2">Kiểm Tra Email</h3>
                         <p class="text-gray-600 text-sm">
                              Sau khi đặt hàng thành công, chúng tôi sẽ gửi email xác nhận với tiêu đề 
                              <strong>"Xác nhận đơn hàng #ORDxxxxx"</strong>. Mã đơn hàng nằm trong email này.
                         </p>
                         </div>
                    </div>
                    
                    <div class="flex gap-4">
                         <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                         2
                         </div>
                         <div class="flex-1">
                         <h3 class="font-semibold text-gray-900 mb-2">Trang Thành Công</h3>
                         <p class="text-gray-600 text-sm">
                              Ngay sau khi đặt hàng, mã đơn hàng sẽ hiển thị trên trang 
                              <strong>"Đặt hàng thành công"</strong>. Hãy lưu lại mã này.
                         </p>
                         </div>
                    </div>
                    
                    <div class="flex gap-4">
                         <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                         3
                         </div>
                         <div class="flex-1">
                         <h3 class="font-semibold text-gray-900 mb-2">Liên Hệ Hỗ Trợ</h3>
                         <p class="text-gray-600 text-sm mb-2">
                              Nếu vẫn không tìm thấy mã đơn hàng, vui lòng liên hệ với chúng tôi:
                         </p>
                         <div class="flex flex-wrap gap-3">
                              <a href="tel:0123456789" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-semibold">
                                   <i class="fas fa-phone mr-1"></i>
                                   0123 456 789
                              </a>
                              <span class="text-gray-300">|</span>
                              <a href="mailto:support@fashionshop.vn" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-semibold">
                                   <i class="fas fa-envelope mr-1"></i>
                                   support@fashionshop.vn
                              </a>
                         </div>
                         </div>
                    </div>
               </div>
          </div>
          
          <!-- Example Order Code -->
          <div class="mt-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-6 text-white text-center">
               <p class="mb-2 opacity-90">Ví dụ về mã đơn hàng:</p>
               <div class="inline-block bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg">
                    <code class="text-2xl font-bold tracking-wider font-mono">ORD65701E3A12B45</code>
               </div>
          </div>
          
          <!-- FAQ -->
          <div class="mt-8 bg-white rounded-lg shadow-md p-6">
               <h3 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-question-circle text-blue-600 mr-2"></i>
                    Câu Hỏi Thường Gặp
               </h3>
               
               <div class="space-y-3" x-data="{ openFaq: null }">
                    <div class="border-b border-gray-200 pb-3">
                         <button @click="openFaq = openFaq === 1 ? null : 1" 
                              class="w-full text-left flex justify-between items-center font-semibold text-gray-900 hover:text-blue-600">
                         <span>Tại sao tôi cần nhập email?</span>
                         <i class="fas fa-chevron-down transition-transform text-sm" :class="openFaq === 1 ? 'rotate-180' : ''"></i>
                         </button>
                         <div x-show="openFaq === 1" x-transition class="mt-2 text-sm text-gray-600">
                         Email dùng để xác minh bạn là chủ sở hữu của đơn hàng, đảm bảo an toàn thông tin.
                         </div>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                         <button @click="openFaq = openFaq === 2 ? null : 2" 
                              class="w-full text-left flex justify-between items-center font-semibold text-gray-900 hover:text-blue-600">
                         <span>Mất bao lâu để đơn hàng được cập nhật?</span>
                         <i class="fas fa-chevron-down transition-transform text-sm" :class="openFaq === 2 ? 'rotate-180' : ''"></i>
                         </button>
                         <div x-show="openFaq === 2" x-transition class="mt-2 text-sm text-gray-600">
                         Trạng thái đơn hàng được cập nhật trong vòng 1-2 giờ sau mỗi thay đổi.
                         </div>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-3">
                         <button @click="openFaq = openFaq === 3 ? null : 3" 
                              class="w-full text-left flex justify-between items-center font-semibold text-gray-900 hover:text-blue-600">
                         <span>Tôi có thể hủy đơn hàng không?</span>
                         <i class="fas fa-chevron-down transition-transform text-sm" :class="openFaq === 3 ? 'rotate-180' : ''"></i>
                         </button>
                         <div x-show="openFaq === 3" x-transition class="mt-2 text-sm text-gray-600">
                         Bạn có thể hủy đơn hàng miễn phí khi đơn hàng đang ở trạng thái "Chờ xác nhận" hoặc "Đã xác nhận".
                         </div>
                    </div>
                    
                    <div class="pb-3">
                         <button @click="openFaq = openFaq === 4 ? null : 4" 
                              class="w-full text-left flex justify-between items-center font-semibold text-gray-900 hover:text-blue-600">
                         <span>Làm sao liên hệ shipper?</span>
                         <i class="fas fa-chevron-down transition-transform text-sm" :class="openFaq === 4 ? 'rotate-180' : ''"></i>
                         </button>
                         <div x-show="openFaq === 4" x-transition class="mt-2 text-sm text-gray-600">
                         Khi đơn hàng đang giao, số điện thoại shipper sẽ hiển thị trong trang chi tiết đơn hàng.
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

@push('styles')
<style>
     input::placeholder {
          opacity: 0.5;
     }
     
     input[type="text"]:focus::placeholder,
     input[type="email"]:focus::placeholder {
          opacity: 0.3;
     }
</style>
@endpush

@push('scripts')
<script>
     // Auto uppercase order code
     document.querySelector('input[name="order_code"]').addEventListener('input', function(e) {
          this.value = this.value.toUpperCase();
     });
</script>
@endpush
@endsection