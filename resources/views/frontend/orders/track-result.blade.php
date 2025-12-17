@extends('layouts.app')

@section('title', 'Kết Quả Tra Cứu - Đơn Hàng #' . $order->order_code)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
     <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Back Button -->
          <div class="mb-6">
               <a href="{{ route('order.track.form') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Tra cứu đơn hàng khác
               </a>
          </div>
          
          <!-- Order Found Success -->
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
               <div class="bg-gradient-to-r from-green-600 to-green-500 text-white px-8 py-6">
                    <div class="flex items-center gap-4">
                         <div class="flex-shrink-0 w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                         <i class="fas fa-check-circle text-3xl"></i>
                         </div>
                         <div>
                         <h1 class="text-2xl font-bold mb-1">Đã Tìm Thấy Đơn Hàng!</h1>
                         <p class="text-green-100">Mã đơn hàng: <span class="font-mono font-bold">{{ $order->order_code }}</span></p>
                         </div>
                    </div>
               </div>
               
               <!-- Order Status -->
               <div class="p-8">
                    @php
                         $statusColors = [
                         'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'clock'],
                         'confirmed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'check-circle'],
                         'processing' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'cogs'],
                         'shipping' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800', 'icon' => 'shipping-fast'],
                         'delivered' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'box-check'],
                         'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'times-circle'],
                         ];
                         
                         $statusLabels = [
                         'pending' => 'Chờ xác nhận',
                         'confirmed' => 'Đã xác nhận',
                         'processing' => 'Đang xử lý',
                         'shipping' => 'Đang giao hàng',
                         'delivered' => 'Đã giao hàng',
                         'cancelled' => 'Đã hủy',
                         ];
                         
                         $currentStatus = $statusColors[$order->status] ?? $statusColors['pending'];
                    @endphp
                    
                    <div class="text-center mb-8">
                         <div class="inline-block px-6 py-3 {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} rounded-full text-lg font-bold mb-4">
                         <i class="fas fa-{{ $currentStatus['icon'] }} mr-2"></i>
                         {{ $statusLabels[$order->status] }}
                         </div>
                         <p class="text-gray-600">
                         Cập nhật lúc: {{ $order->updated_at->format('d/m/Y H:i') }}
                         </p>
                    </div>
                    
                    <!-- Timeline -->
                    @if(!in_array($order->status, ['cancelled', 'refunded']))
                         <div class="max-w-3xl mx-auto mb-8">
                         <div class="relative">
                              @php
                                   $timeline = [
                                        'pending' => 'Đã đặt hàng',
                                        'confirmed' => 'Đã xác nhận',
                                        'processing' => 'Đang xử lý',
                                        'shipping' => 'Đang giao',
                                        'delivered' => 'Hoàn thành',
                                   ];
                                   
                                   $currentIndex = array_search($order->status, array_keys($timeline));
                              @endphp
                              
                              <div class="flex justify-between mb-2">
                                   @foreach($timeline as $key => $label)
                                        @php
                                             $index = array_search($key, array_keys($timeline));
                                             $isActive = $index <= $currentIndex;
                                        @endphp
                                        <div class="flex-1 text-center">
                                             <div class="relative">
                                             <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center {{ $isActive ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }} mb-2">
                                                  <i class="fas fa-check"></i>
                                             </div>
                                             @if($index < count($timeline) - 1)
                                                  <div class="absolute top-5 left-1/2 w-full h-0.5 {{ $isActive && $index < $currentIndex ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                                             @endif
                                             </div>
                                             <p class="text-xs {{ $isActive ? 'text-gray-900 font-semibold' : 'text-gray-400' }}">
                                             {{ $label }}
                                             </p>
                                        </div>
                                   @endforeach
                              </div>
                         </div>
                         </div>
                    @endif
                    
                    <!-- Order Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-4">
                         <h3 class="font-bold text-lg mb-4 flex items-center">
                              <i class="fas fa-box text-blue-600 mr-2"></i>
                              Thông Tin Đơn Hàng
                         </h3>
                         <div class="space-y-3 text-sm">
                              <div class="flex justify-between">
                                   <span class="text-gray-600">Mã đơn hàng:</span>
                                   <span class="font-semibold font-mono">{{ $order->order_code }}</span>
                              </div>
                              <div class="flex justify-between">
                                   <span class="text-gray-600">Ngày đặt:</span>
                                   <span class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                              </div>
                              <div class="flex justify-between">
                                   <span class="text-gray-600">Số sản phẩm:</span>
                                   <span class="font-semibold">{{ $order->orderDetails->sum('quantity') }}</span>
                              </div>
                              <div class="flex justify-between">
                                   <span class="text-gray-600">Tổng tiền:</span>
                                   <span class="font-bold text-blue-600 text-lg">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                              </div>
                         </div>
                         </div>
                         
                         <div class="space-y-4">
                         <h3 class="font-bold text-lg mb-4 flex items-center">
                              <i class="fas fa-truck text-blue-600 mr-2"></i>
                              Thông Tin Giao Hàng
                         </h3>
                         <div class="space-y-3 text-sm">
                              <div>
                                   <span class="text-gray-600 block mb-1">Người nhận:</span>
                                   <span class="font-semibold">{{ $order->customer_name }}</span>
                              </div>
                              <div>
                                   <span class="text-gray-600 block mb-1">Số điện thoại:</span>
                                   <span class="font-semibold">{{ $order->customer_phone }}</span>
                              </div>
                              <div>
                                   <span class="text-gray-600 block mb-1">Địa chỉ:</span>
                                   <span class="font-semibold">{{ $order->customer_address }}</span>
                              </div>
                         </div>
                         </div>
                    </div>
               </div>
          </div>
          
          <!-- Order Items -->
          <div class="bg-white rounded-2xl shadow-xl p-8">
               <h2 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-shopping-bag text-blue-600 mr-2"></i>
                    Sản Phẩm Trong Đơn Hàng
               </h2>
               
               <div class="space-y-4">
                    @foreach($order->orderDetails as $detail)
                         <div class="flex gap-4 p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                         <img src="{{ $detail->product_image }}" 
                              alt="{{ $detail->product_name }}"
                              class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                         
                         <div class="flex-1">
                              <h3 class="font-semibold text-gray-900 mb-2">{{ $detail->product_name }}</h3>
                              <div class="text-sm text-gray-600 space-y-1">
                                   @if($detail->size || $detail->color)
                                        <div>
                                             @if($detail->size)Size: {{ $detail->size }}@endif
                                             @if($detail->size && $detail->color) | @endif
                                             @if($detail->color)Màu: {{ $detail->color }}@endif
                                        </div>
                                   @endif
                                   <div>Số lượng: {{ $detail->quantity }} x {{ number_format($detail->price, 0, ',', '.') }}đ</div>
                              </div>
                         </div>
                         
                         <div class="text-right flex-shrink-0">
                              <div class="font-bold text-blue-600">
                                   {{ number_format($detail->total, 0, ',', '.') }}đ
                              </div>
                         </div>
                         </div>
                    @endforeach
               </div>
          </div>
          
          <!-- Actions -->
          <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
               <a href="{{ route('order.track.form') }}" 
                    class="inline-flex items-center justify-center px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                    <i class="fas fa-search mr-2"></i>
                    Tra Cứu Đơn Khác
               </a>
               
               <a href="{{ route('contact') }}" 
                    class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-headset mr-2"></i>
                    Liên Hệ Hỗ Trợ
               </a>
          </div>
     </div>
</div>
@endsection