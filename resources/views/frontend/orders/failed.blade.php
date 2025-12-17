@extends('layouts.app')

@section('title', 'Thanh Toán Thất Bại - Fashion Shop')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
     <!-- Failed Animation -->
     <div class="text-center mb-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
          <div x-show="show" 
               x-transition:enter="transition ease-out duration-500"
               x-transition:enter-start="opacity-0 scale-50"
               x-transition:enter-end="opacity-100 scale-100"
               class="inline-block">
               <div class="w-32 h-32 mx-auto mb-6 bg-red-100 rounded-full flex items-center justify-center relative">
                    <i class="fas fa-times text-6xl text-red-600"></i>
                    <div class="absolute inset-0 rounded-full border-4 border-red-600 animate-ping opacity-75"></div>
               </div>
          </div>
          
          <h1 class="text-4xl font-bold text-gray-900 mb-3">Thanh Toán Thất Bại!</h1>
          <p class="text-lg text-gray-600">
               Đơn hàng của bạn chưa được thanh toán hoặc đã bị hủy
          </p>
     </div>
    
     <!-- Order Info Card -->
     <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
          <!-- Header -->
          <div class="bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-6">
               <div class="flex items-center justify-between">
                    <div>
                         <h2 class="text-2xl font-bold mb-2">Đơn Hàng #{{ $order->order_code }}</h2>
                         <p class="text-red-100">
                         <i class="fas fa-calendar-alt mr-2"></i>
                         {{ $order->created_at->format('d/m/Y H:i') }}
                         </p>
                    </div>
                    <div class="hidden md:block">
                         <i class="fas fa-exclamation-triangle text-6xl opacity-20"></i>
                    </div>
               </div>
          </div>
          
          <!-- Content -->
          <div class="p-6">
               <!-- Error Message -->
               <div class="mb-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-600">
                    <div class="flex items-start gap-3">
                         <i class="fas fa-exclamation-circle text-red-600 text-xl mt-1"></i>
                         <div>
                         <h3 class="font-semibold text-gray-900 mb-1">Giao dịch không thành công</h3>
                         <p class="text-sm text-gray-600">
                              {{ session('error') ?? 'Đơn hàng của bạn đã bị hủy do thanh toán không thành công hoặc bạn đã hủy giao dịch trên cổng thanh toán MoMo.' }}
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Payment Info -->
               <div class="mb-6 p-4 rounded-lg bg-gray-50 border-l-4 border-gray-400">
                    <div class="flex items-start gap-3">
                         <i class="fas fa-wallet text-gray-600 text-xl mt-1"></i>
                         <div>
                         <h3 class="font-semibold text-gray-900 mb-1">
                              Thanh toán qua MoMo
                         </h3>
                         <p class="text-sm text-gray-600">
                              Giao dịch đã bị hủy hoặc không thành công. Đơn hàng của bạn đã được hủy tự động.
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Order Info -->
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                         <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                         <i class="fas fa-truck text-gray-600 mr-2"></i>
                         Thông Tin Giao Hàng
                         </h3>
                         <div class="space-y-2 text-sm">
                         <div>
                              <span class="text-gray-500">Người nhận:</span>
                              <span class="font-medium ml-2">{{ $order->customer_name }}</span>
                         </div>
                         <div>
                              <span class="text-gray-500">Số điện thoại:</span>
                              <span class="font-medium ml-2">{{ $order->customer_phone }}</span>
                         </div>
                         <div>
                              <span class="text-gray-500">Địa chỉ:</span>
                              <span class="font-medium ml-2">{{ $order->customer_address }}</span>
                         </div>
                         </div>
                    </div>
                    
                    <div class="p-4 bg-gray-50 rounded-lg">
                         <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                         <i class="fas fa-receipt text-gray-600 mr-2"></i>
                         Tóm Tắt Đơn Hàng
                         </h3>
                         <div class="space-y-2 text-sm">
                         <div class="flex justify-between">
                              <span class="text-gray-500">Sản phẩm ({{ $order->orderDetails->count() }}):</span>
                              <span class="font-medium">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                         </div>
                         <div class="flex justify-between">
                              <span class="text-gray-500">Phí vận chuyển:</span>
                              <span class="font-medium">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
                         </div>
                         @if($order->discount_amount > 0)
                              <div class="flex justify-between text-green-600">
                                   <span>Giảm giá:</span>
                                   <span class="font-medium">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                              </div>
                         @endif
                         <div class="flex justify-between pt-2 border-t border-gray-300">
                              <span class="font-bold text-gray-900">Tổng cộng:</span>
                              <span class="font-bold text-red-600 text-lg">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                         </div>
                         </div>
                    </div>
               </div>
               
               <!-- Order Items Preview -->
               <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-box text-gray-600 mr-2"></i>
                         Sản Phẩm Trong Đơn Hàng
                    </h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                         @foreach($order->orderDetails as $detail)
                         <div class="flex gap-4 p-3 bg-gray-50 rounded-lg">
                              <img src="{{ $detail->product_image }}" 
                                   alt="{{ $detail->product_name }}"
                                   class="w-16 h-16 object-cover rounded flex-shrink-0">
                              
                              <div class="flex-1 min-w-0">
                                   <h4 class="font-medium text-gray-900 text-sm truncate">{{ $detail->product_name }}</h4>
                                   <p class="text-xs text-gray-500 mt-1">
                                        @if($detail->size || $detail->color)
                                             @if($detail->size)Size: {{ $detail->size }}@endif
                                             @if($detail->size && $detail->color) | @endif
                                             @if($detail->color)Màu: {{ $detail->color }}@endif
                                        @endif
                                   </p>
                                   <p class="text-xs text-gray-600 mt-1">
                                        {{ $detail->quantity }} x {{ number_format($detail->price, 0, ',', '.') }}đ
                                   </p>
                              </div>
                              
                              <div class="text-right flex-shrink-0">
                                   <div class="font-semibold text-gray-600 text-sm">
                                        {{ number_format($detail->total, 0, ',', '.') }}đ
                                   </div>
                              </div>
                         </div>
                         @endforeach
                    </div>
               </div>
               
               <!-- Action Buttons -->
               <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('checkout.index') }}" 
                    class="flex-1 bg-red-600 text-white text-center px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                         <i class="fas fa-redo mr-2"></i>
                         Thử Thanh Toán Lại
                    </a>
                    
                    <a href="{{ route('order.show', $order->id) }}" 
                    class="flex-1 bg-white text-gray-700 border-2 border-gray-300 text-center px-6 py-3 rounded-lg hover:bg-gray-50 transition font-semibold">
                         <i class="fas fa-eye mr-2"></i>
                         Xem Chi Tiết Đơn Hàng
                    </a>
                    
                    <a href="{{ route('products.index') }}" 
                    class="flex-1 bg-white text-blue-600 border-2 border-blue-600 text-center px-6 py-3 rounded-lg hover:bg-blue-50 transition font-semibold">
                         <i class="fas fa-shopping-bag mr-2"></i>
                         Tiếp Tục Mua Sắm
                    </a>
               </div>
          </div>
     </div>
    
     <!-- Why Failed & Solutions -->
     <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-question-circle text-red-600 mr-2"></i>
                    Tại sao thanh toán thất bại?
               </h3>
               <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start">
                         <i class="fas fa-dot-circle text-red-500 mt-1 mr-2 text-xs"></i>
                         <span>Số dư tài khoản MoMo không đủ</span>
                    </li>
                    <li class="flex items-start">
                         <i class="fas fa-dot-circle text-red-500 mt-1 mr-2 text-xs"></i>
                         <span>Bạn đã hủy giao dịch trên cổng thanh toán</span>
                    </li>
                    <li class="flex items-start">
                         <i class="fas fa-dot-circle text-red-500 mt-1 mr-2 text-xs"></i>
                         <span>Phiên giao dịch đã hết hạn</span>
                    </li>
                    <li class="flex items-start">
                         <i class="fas fa-dot-circle text-red-500 mt-1 mr-2 text-xs"></i>
                         <span>Lỗi kết nối mạng trong quá trình thanh toán</span>
                    </li>
               </ul>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                    Bạn có thể làm gì?
               </h3>
               <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start">
                         <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                         <span>Kiểm tra số dư tài khoản MoMo của bạn</span>
                    </li>
                    <li class="flex items-start">
                         <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                         <span>Thử thanh toán lại với phương thức khác (COD)</span>
                    </li>
                    <li class="flex items-start">
                         <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                         <span>Kiểm tra kết nối internet của bạn</span>
                    </li>
                    <li class="flex items-start">
                         <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                         <span>Liên hệ hotline để được hỗ trợ: 0123 456 789</span>
                    </li>
               </ul>
          </div>
     </div>
    
     <!-- Payment Methods -->
     <div class="bg-white rounded-lg shadow-md p-6 mb-8">
          <h3 class="text-xl font-bold mb-6 text-center">Phương Thức Thanh Toán Khác</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
               <div class="p-4 border-2 border-yellow-400 rounded-lg hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-2">
                         <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                              <i class="fas fa-money-bill-wave text-2xl text-yellow-600"></i>
                         </div>
                         <div>
                              <h4 class="font-semibold text-gray-900">Thanh toán khi nhận hàng (COD)</h4>
                              <p class="text-sm text-gray-600">Thanh toán tiền mặt khi nhận hàng</p>
                         </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" 
                       class="block text-center mt-3 px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition text-sm font-semibold">
                         Đặt hàng với COD
                    </a>
               </div>
               
               <div class="p-4 border-2 border-pink-400 rounded-lg hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-2">
                         <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                              <i class="fas fa-wallet text-2xl text-pink-600"></i>
                         </div>
                         <div>
                              <h4 class="font-semibold text-gray-900">Thanh toán MoMo</h4>
                              <p class="text-sm text-gray-600">Quét mã QR để thanh toán nhanh</p>
                         </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" 
                       class="block text-center mt-3 px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700 transition text-sm font-semibold">
                         Thử lại với MoMo
                    </a>
               </div>
          </div>
     </div>
    
     <!-- FAQ -->
     <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-xl font-bold mb-6 text-center">Câu Hỏi Thường Gặp</h3>
          
          <div class="space-y-4" x-data="{ openFaq: null }">
               <div class="border-b border-gray-200 pb-4">
                    <button @click="openFaq = openFaq === 1 ? null : 1" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Tiền có bị trừ khi thanh toán thất bại không?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 1" x-transition class="mt-3 text-sm text-gray-600">
                         Nếu giao dịch thất bại, tiền sẽ KHÔNG bị trừ khỏi tài khoản MoMo của bạn. 
                         Nếu có bất kỳ vấn đề gì, vui lòng liên hệ với MoMo hoặc với chúng tôi để được hỗ trợ.
                    </div>
               </div>
               
               <div class="border-b border-gray-200 pb-4">
                    <button @click="openFaq = openFaq === 2 ? null : 2" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Tôi có thể đặt lại đơn hàng này không?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 2" x-transition class="mt-3 text-sm text-gray-600">
                         Có, bạn có thể thử thanh toán lại bằng cách click vào nút "Thử Thanh Toán Lại" ở trên, 
                         hoặc đặt hàng mới với các sản phẩm tương tự từ giỏ hàng.
                    </div>
               </div>
               
               <div class="border-b border-gray-200 pb-4">
                    <button @click="openFaq = openFaq === 3 ? null : 3" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Sản phẩm trong đơn hàng có còn không?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 3" x-transition class="mt-3 text-sm text-gray-600">
                         Do đơn hàng đã bị hủy, tồn kho đã được hoàn lại. Tuy nhiên, nếu bạn đặt hàng lại ngay, 
                         khả năng cao sản phẩm vẫn còn. Nếu hết hàng, chúng tôi sẽ thông báo cho bạn.
                    </div>
               </div>
               
               <div class="pb-4">
                    <button @click="openFaq = openFaq === 4 ? null : 4" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Tôi cần hỗ trợ thêm, liên hệ ai?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 4" x-transition class="mt-3 text-sm text-gray-600">
                         Bạn có thể liên hệ với chúng tôi qua hotline 
                         <a href="tel:0123456789" class="text-blue-600 hover:underline">0123 456 789</a> 
                         hoặc gửi email qua trang <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">Liên hệ</a>.
                    </div>
               </div>
          </div>
     </div>
    
     <!-- Support Contact -->
     <div class="mt-8 text-center">
          <p class="text-gray-600 mb-4">Cần hỗ trợ ngay? Chúng tôi luôn sẵn sàng giúp đỡ bạn</p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
               <a href="tel:0123456789" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-phone mr-2"></i>
                    Gọi Hotline: 0123 456 789
               </a>
               
               <a href="{{ route('contact') }}" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-envelope mr-2"></i>
                    Gửi Email Hỗ Trợ
               </a>
          </div>
     </div>
</div>

@push('styles')
<style>
     @keyframes ping {
          75%, 100% {
               transform: scale(2);
               opacity: 0;
          }
     }
    
     .animate-ping {
          animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
     }
</style>
@endpush
@endsection