@extends('layouts.app')

@section('title', 'Liên Hệ - Fashion Shop')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-4">Liên Hệ Với Chúng Tôi</h1>
        <p class="text-xl">Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
               <!-- Contact Form -->
               <div class="bg-white rounded-lg shadow-md p-8">
               <h2 class="text-2xl font-bold mb-6">Gửi Tin Nhắn</h2>
                
               <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên *</label>
                         <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         @error('name')
                              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                         @enderror
                    </div>
                    
                    <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                         <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         @error('email')
                              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                         @enderror
                    </div>
                    
                    <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">Chủ Đề *</label>
                         <input type="text" name="subject" value="{{ old('subject') }}" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         @error('subject')
                              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                         @enderror
                    </div>
                    
                    <div>
                         <label class="block text-sm font-medium text-gray-700 mb-2">Nội Dung *</label>
                         <textarea name="message" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('message') }}</textarea>
                         @error('message')
                              <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                         @enderror
                    </div>
                    
                    <button type="submit" 
                         class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Gửi Tin Nhắn
                    </button>
               </form>
          </div>
            
          <!-- Contact Info -->
          <div class="space-y-8">
               <!-- Contact Details -->
               <div class="bg-white rounded-lg shadow-md p-8">
               <h2 class="text-2xl font-bold mb-6">Thông Tin Liên Hệ</h2>
                    
                    <div class="space-y-6">
                         <div class="flex items-start gap-4">
                              <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                              </div>
                              <div>
                                   <h3 class="font-semibold mb-1">Địa Chỉ</h3>
                                   <p class="text-gray-600">180 Cao Lỗ, Quận 8<br>TP. Hồ Chí Minh, Việt Nam</p>
                              </div>
                         </div>
                        
                         <div class="flex items-start gap-4">
                              <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-phone text-green-600 text-xl"></i>
                              </div>
                              <div>
                                   <h3 class="font-semibold mb-1">Điện Thoại</h3>
                                   <p class="text-gray-600">Hotline: <a href="tel:0123456789" class="text-blue-600 hover:underline">0123 456 789</a></p>
                                   <p class="text-gray-600">Support: <a href="tel:0987654321" class="text-blue-600 hover:underline">0987 654 321</a></p>
                              </div>
                         </div>
                        
                         <div class="flex items-start gap-4">
                              <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-envelope text-yellow-600 text-xl"></i>
                              </div>
                              <div>
                                   <h3 class="font-semibold mb-1">Email</h3>
                                   <p class="text-gray-600">
                                        <a href="mailto:info@fashionshop.vn" class="text-blue-600 hover:underline">info@fashionshop.vn</a><br>
                                        <a href="mailto:support@fashionshop.vn" class="text-blue-600 hover:underline">support@fashionshop.vn</a>
                                   </p>
                              </div>
                         </div>
                        
                         <div class="flex items-start gap-4">
                              <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-clock text-purple-600 text-xl"></i>
                              </div>
                              <div>
                                   <h3 class="font-semibold mb-1">Giờ Làm Việc</h3>
                                   <p class="text-gray-600">
                                        Thứ 2 - Thứ 6: 8:00 - 21:00<br>
                                        Thứ 7 - CN: 9:00 - 20:00
                                   </p>
                              </div>
                         </div>
                    </div>
                </div>
                
                <!-- Social Media -->
               <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold mb-6">Kết Nối Với Chúng Tôi</h2>
                    
                    <div class="grid grid-cols-4 gap-4">
                         <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-600 hover:bg-blue-50 transition group">
                              <i class="fab fa-facebook text-3xl text-gray-400 group-hover:text-blue-600 mb-2"></i>
                              <span class="text-xs text-gray-600 group-hover:text-blue-600">Facebook</span>
                         </a>
                         
                         <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-pink-600 hover:bg-pink-50 transition group">
                              <i class="fab fa-instagram text-3xl text-gray-400 group-hover:text-pink-600 mb-2"></i>
                              <span class="text-xs text-gray-600 group-hover:text-pink-600">Instagram</span>
                         </a>
                         
                         <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-800 hover:bg-gray-50 transition group">
                              <i class="fab fa-tiktok text-3xl text-gray-400 group-hover:text-gray-800 mb-2"></i>
                              <span class="text-xs text-gray-600 group-hover:text-gray-800">TikTok</span>
                         </a>
                         
                         <a href="#" class="flex flex-col items-center justify-center p-4 border-2 border-gray-200 rounded-lg hover:border-red-600 hover:bg-red-50 transition group">
                              <i class="fab fa-youtube text-3xl text-gray-400 group-hover:text-red-600 mb-2"></i>
                              <span class="text-xs text-gray-600 group-hover:text-red-600">YouTube</span>
                         </a>
                    </div>
                </div>
                
                <!-- Map -->
               <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1794.0935097795366!2d106.67750150501574!3d10.738032219393057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fad3fb62a95%3A0xa9576c84a879d1fe!2zMTgwIENhbyBM4buXLCBQaMaw4budbmcgNCwgUXXhuq1uIDgsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCA3MDAwMCwgVmnhu4d0IE5hbQ!5e1!3m2!1svi!2s!4v1764985021521!5m2!1svi!2s" 
                         width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
               </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">  
    <h2 class="text-3xl font-bold text-center mb-12">Câu Hỏi Thường Gặp</h2>
        
     <div class="space-y-4" x-data="{ openFaq: null }">
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <button @click="openFaq = openFaq === 1 ? null : 1" 
                    class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="font-semibold">Làm sao để đặt hàng?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="openFaq === 1 ? 'rotate-180' : ''"></i>
               </button>
               <div x-show="openFaq === 1" x-transition class="px-6 py-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Bạn có thể đặt hàng trực tiếp trên website bằng cách chọn sản phẩm, thêm vào giỏ hàng và tiến hành thanh toán. 
                        Hoặc liên hệ hotline để được tư vấn và đặt hàng qua điện thoại.
                    </p>
               </div>
          </div>
            
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <button @click="openFaq = openFaq === 2 ? null : 2" 
                    class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="font-semibold">Thời gian giao hàng là bao lâu?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="openFaq === 2 ? 'rotate-180' : ''"></i>
               </button>
               <div x-show="openFaq === 2" x-transition class="px-6 py-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Thời gian giao hàng trong nội thành TP.HCM là 1-2 ngày. 
                        Các tỉnh thành khác từ 2-5 ngày tùy khu vực.
                    </p>
               </div>
          </div>
            
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <button @click="openFaq = openFaq === 3 ? null : 3" 
                    class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="font-semibold">Chính sách đổi trả như thế nào?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="openFaq === 3 ? 'rotate-180' : ''"></i>
               </button>
               <div x-show="openFaq === 3" x-transition class="px-6 py-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Bạn có thể đổi trả sản phẩm trong vòng 7 ngày nếu sản phẩm còn nguyên tem mác, chưa qua sử dụng. 
                        Vui lòng liên hệ hotline để được hỗ trợ.
                    </p>
               </div>
          </div>
            
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <button @click="openFaq = openFaq === 4 ? null : 4" 
                    class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="font-semibold">Có miễn phí vận chuyển không?</span>
                    <i class="fas fa-chevron-down transition-transform" :class="openFaq === 4 ? 'rotate-180' : ''"></i>
               </button>
               <div x-show="openFaq === 4" x-transition class="px-6 py-4 border-t border-gray-200">
                    <p class="text-gray-600">
                         Chúng tôi miễn phí vận chuyển cho đơn hàng từ 500,000đ trở lên.
                         Đơn hàng dưới 500,000đ sẽ có phí vận chuyển 30,000đ.
                    </p>
               </div>
          </div>
     </div>
</div>
</section>
@endsection