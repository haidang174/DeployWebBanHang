@extends('layouts.app')

@section('title', 'Đặt Hàng Thành Công - Fashion Shop')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
     <!-- Success Animation -->
     <div class="text-center mb-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
          <div x-show="show" 
               x-transition:enter="transition ease-out duration-500"
               x-transition:enter-start="opacity-0 scale-50"
               x-transition:enter-end="opacity-100 scale-100"
               class="inline-block">
               <div class="w-32 h-32 mx-auto mb-6 bg-green-100 rounded-full flex items-center justify-center relative">
                    <i class="fas fa-check text-6xl text-green-600"></i>
                    <div class="absolute inset-0 rounded-full border-4 border-green-600 animate-ping opacity-75"></div>
               </div>
          </div>
          
          <h1 class="text-4xl font-bold text-gray-900 mb-3">Đặt Hàng Thành Công!</h1>
          <p class="text-lg text-gray-600">
               Cảm ơn bạn đã tin tưởng và mua sắm tại Fashion Shop
          </p>
     </div>
    
     <!-- Order Info Card -->
     <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
          <!-- Header -->
          <div class="bg-gradient-to-r from-green-600 to-green-500 text-white px-6 py-6">
               <div class="flex items-center justify-between">
                    <div>
                         <h2 class="text-2xl font-bold mb-2">Đơn Hàng #{{ $order->order_code }}</h2>
                         <p class="text-green-100">
                         <i class="fas fa-calendar-alt mr-2"></i>
                         {{ $order->created_at->format('d/m/Y H:i') }}
                         </p>
                    </div>
                    <div class="hidden md:block">
                         <i class="fas fa-shopping-bag text-6xl opacity-20"></i>
                    </div>
               </div>
          </div>
          
          <!-- Content -->
          <div class="p-6">
               <!-- Order Status -->
               <div class="mb-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-600">
                    <div class="flex items-start gap-3">
                         <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
                         <div>
                         <h3 class="font-semibold text-gray-900 mb-1">Đơn hàng của bạn đang được xử lý</h3>
                         <p class="text-sm text-gray-600">
                              Chúng tôi sẽ gửi email xác nhận đến <strong>{{ $order->customer_email }}</strong> 
                              khi đơn hàng được xác nhận và chuẩn bị giao.
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Payment Info -->
               <div class="mb-6 p-4 rounded-lg {{ $order->payment_method === 'cod' ? 'bg-yellow-50 border-l-4 border-yellow-600' : 'bg-pink-50 border-l-4 border-pink-600' }}">
                    <div class="flex items-start gap-3">
                         <i class="fas {{ $order->payment_method === 'cod' ? 'fa-money-bill-wave text-yellow-600' : 'fa-wallet text-pink-600' }} text-xl mt-1"></i>
                         <div>
                         <h3 class="font-semibold text-gray-900 mb-1">
                              @if($order->payment_method === 'cod')
                                   Thanh toán khi nhận hàng (COD)
                              @else
                                   Thanh toán qua Momo
                              @endif
                         </h3>
                         <p class="text-sm text-gray-600">
                              @if($order->payment_method === 'cod')
                                   Vui lòng chuẩn bị <strong class="text-lg">{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong> 
                                   để thanh toán cho nhân viên giao hàng.
                              @else
                                   Đơn hàng của bạn sẽ được xác nhận sau khi thanh toán thành công.
                              @endif
                         </p>
                         </div>
                    </div>
               </div>
               
               <!-- Delivery Info -->
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                         <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                         <i class="fas fa-truck text-blue-600 mr-2"></i>
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
                         <i class="fas fa-receipt text-blue-600 mr-2"></i>
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
                              <span class="font-bold text-blue-600 text-lg">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                         </div>
                         </div>
                    </div>
               </div>
               
               <!-- Order Items Preview -->
               <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-box text-blue-600 mr-2"></i>
                         Sản Phẩm Đã Đặt
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
                                   <div class="font-semibold text-blue-600 text-sm">
                                        {{ number_format($detail->total, 0, ',', '.') }}đ
                                   </div>
                              </div>
                         </div>
                         @endforeach
                    </div>
               </div>
               
               <!-- Action Buttons -->
               <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('order.show', $order->id) }}" 
                    class="flex-1 bg-blue-600 text-white text-center px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
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
    
     <!-- Additional Info -->
     <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div class="bg-white rounded-lg shadow-md p-6 text-center">
               <div class="w-12 h-12 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shipping-fast text-2xl text-blue-600"></i>
               </div>
               <h3 class="font-semibold mb-2">Giao Hàng Nhanh</h3>
               <p class="text-sm text-gray-600">Dự kiến giao trong 2-5 ngày</p>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-6 text-center">
               <div class="w-12 h-12 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-undo text-2xl text-green-600"></i>
               </div>
               <h3 class="font-semibold mb-2">Đổi Trả Dễ Dàng</h3>
               <p class="text-sm text-gray-600">Trong vòng 7 ngày nếu có vấn đề</p>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-6 text-center">
               <div class="w-12 h-12 mx-auto mb-3 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-headset text-2xl text-purple-600"></i>
               </div>
               <h3 class="font-semibold mb-2">Hỗ Trợ 24/7</h3>
               <p class="text-sm text-gray-600">Luôn sẵn sàng hỗ trợ bạn</p>
          </div>
     </div>
    
     <!-- FAQ -->
     <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-xl font-bold mb-6 text-center">Câu Hỏi Thường Gặp</h3>
          
          <div class="space-y-4" x-data="{ openFaq: null }">
               <div class="border-b border-gray-200 pb-4">
                    <button @click="openFaq = openFaq === 1 ? null : 1" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Làm sao để theo dõi đơn hàng?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 1" x-transition class="mt-3 text-sm text-gray-600">
                         Bạn có thể theo dõi đơn hàng tại trang 
                         <a href="{{ route('order.index') }}" class="text-blue-600 hover:underline">Đơn hàng của tôi</a> 
                         hoặc qua email xác nhận đã được gửi đến hộp thư của bạn.
                    </div>
               </div>
               
               <div class="border-b border-gray-200 pb-4">
                    <button @click="openFaq = openFaq === 2 ? null : 2" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Tôi có thể thay đổi địa chỉ giao hàng không?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 2" x-transition class="mt-3 text-sm text-gray-600">
                         Bạn có thể thay đổi địa chỉ trong vòng 1 giờ sau khi đặt hàng bằng cách liên hệ hotline 
                         <a href="tel:0123456789" class="text-blue-600 hover:underline">0123 456 789</a>.
                    </div>
               </div>
               
               <div class="border-b border-gray-200 pb-4">
                    <button @click="openFaq = openFaq === 3 ? null : 3" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Làm sao để hủy đơn hàng?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 3" x-transition class="mt-3 text-sm text-gray-600">
                         Bạn có thể hủy đơn hàng miễn phí khi đơn hàng đang ở trạng thái "Chờ xác nhận" hoặc "Đã xác nhận" 
                         tại trang chi tiết đơn hàng.
                    </div>
               </div>
               
               <div class="pb-4">
                    <button @click="openFaq = openFaq === 4 ? null : 4" 
                         class="w-full text-left flex justify-between items-center font-semibold text-gray-900">
                         <span>Chính sách đổi trả như thế nào?</span>
                         <i class="fas fa-chevron-down transition-transform" :class="openFaq === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFaq === 4" x-transition class="mt-3 text-sm text-gray-600">
                         Bạn có thể đổi/trả sản phẩm trong vòng 7 ngày nếu sản phẩm còn nguyên tem mác, chưa qua sử dụng. 
                         Chi tiết vui lòng xem tại <a href="#" class="text-blue-600 hover:underline">Chính sách đổi trả</a>.
                    </div>
               </div>
          </div>
     </div>
    
     <!-- Support Contact -->
     <div class="mt-8 text-center">
          <p class="text-gray-600 mb-4">Cần hỗ trợ? Chúng tôi luôn sẵn sàng giúp đỡ bạn</p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
               <a href="tel:0123456789" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-phone mr-2"></i>
                    Gọi: 0123 456 789
               </a>
               
               <a href="{{ route('contact') }}" 
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-envelope mr-2"></i>
                    Gửi Email
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