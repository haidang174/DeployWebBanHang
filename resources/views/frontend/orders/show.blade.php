@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Hàng #' . $order->order_code . ' - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
     <!-- Breadcrumb -->
     <nav class="mb-6 text-sm">
          <ol class="flex items-center space-x-2">
               <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
               <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
               <li><a href="{{ route('order.index') }}" class="text-blue-600 hover:text-blue-800">Đơn hàng của tôi</a></li>
               <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
               <li class="text-gray-600">{{ $order->order_code }}</li>
          </ol>
     </nav>
    
     <!-- Order Header -->
     <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
               <div>
                    <h1 class="text-2xl font-bold mb-2">Đơn Hàng #{{ $order->order_code }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                         <span>
                         <i class="fas fa-calendar-alt mr-1"></i>
                         {{ $order->created_at->format('d/m/Y H:i') }}
                         </span>
                         <span class="hidden md:inline">•</span>
                         <span>
                         <i class="fas fa-box mr-1"></i>
                         {{ $order->orderDetails->count() }} sản phẩm
                         </span>
                         <span class="hidden md:inline">•</span>
                         @php
                         $statusColors = [
                              'pending' => 'bg-yellow-100 text-yellow-800',
                              'confirmed' => 'bg-blue-100 text-blue-800',
                              'processing' => 'bg-purple-100 text-purple-800',
                              'shipping' => 'bg-indigo-100 text-indigo-800',
                              'delivered' => 'bg-green-100 text-green-800',
                              'cancelled' => 'bg-red-100 text-red-800',
                              'refunded' => 'bg-gray-100 text-gray-800',
                         ];
                         
                         $statusLabels = [
                              'pending' => 'Chờ xác nhận',
                              'confirmed' => 'Đã xác nhận',
                              'processing' => 'Đang xử lý',
                              'shipping' => 'Đang giao hàng',
                              'delivered' => 'Đã giao hàng',
                              'cancelled' => 'Đã hủy',
                              'refunded' => 'Đã hoàn tiền',
                         ];
                         @endphp
                         <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] }}">
                         {{ $statusLabels[$order->status] }}
                         </span>
                    </div>
               </div>
               
               <div class="flex gap-2">
                    @if($order->canBeCancelled())
                         <form action="{{ route('order.cancel', $order->id) }}" method="POST" 
                              onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                         @csrf
                         <button type="submit" 
                                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                              <i class="fas fa-times-circle mr-1"></i>
                              Hủy Đơn
                         </button>
                         </form>
                    @endif
                    
                    <button onclick="window.print()" 
                         class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold">
                         <i class="fas fa-print mr-1"></i>
                         In Đơn
                    </button>
               </div>
          </div>
     </div>
    
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Main Content -->
          <div class="lg:col-span-2 space-y-6">
               <!-- Order Timeline -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6">Trạng Thái Đơn Hàng</h2>
                    
                    <div class="relative">
                         @php
                         $statuses = [
                              'pending' => ['label' => 'Chờ xác nhận', 'icon' => 'clock'],
                              'confirmed' => ['label' => 'Đã xác nhận', 'icon' => 'check-circle'],
                              'processing' => ['label' => 'Đang xử lý', 'icon' => 'cogs'],
                              'shipping' => ['label' => 'Đang giao hàng', 'icon' => 'shipping-fast'],
                              'delivered' => ['label' => 'Đã giao hàng', 'icon' => 'box-check'],
                         ];
                         
                         $currentStatusIndex = array_search($order->status, array_keys($statuses));
                         $isCancelled = in_array($order->status, ['cancelled', 'refunded']);
                         @endphp
                         
                         @if(!$isCancelled)
                         <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                         
                         @foreach($statuses as $statusKey => $statusInfo)
                              @php
                                   $statusIndex = array_search($statusKey, array_keys($statuses));
                                   $isActive = $statusIndex <= $currentStatusIndex;
                                   $isCurrent = $statusKey === $order->status;
                              @endphp
                              
                              <div class="relative flex items-start mb-8 last:mb-0">
                                   <div class="flex-shrink-0 w-16 h-16 rounded-full flex items-center justify-center {{ $isActive ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }} {{ $isCurrent ? 'ring-4 ring-blue-200' : '' }} z-10">
                                        <i class="fas fa-{{ $statusInfo['icon'] }} text-2xl"></i>
                                   </div>
                                   
                                   <div class="ml-6 flex-1">
                                        <h3 class="font-semibold text-lg {{ $isActive ? 'text-gray-900' : 'text-gray-400' }}">
                                             {{ $statusInfo['label'] }}
                                        </h3>
                                        @if($isCurrent)
                                             <p class="text-sm text-gray-500 mt-1">
                                             Cập nhật lúc: {{ $order->updated_at->format('d/m/Y H:i') }}
                                             </p>
                                        @endif
                                   </div>
                              </div>
                         @endforeach
                         @else
                         <div class="text-center py-8">
                              <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center bg-red-100 text-red-600 mb-4">
                                   <i class="fas fa-times-circle text-4xl"></i>
                              </div>
                              <h3 class="text-xl font-bold text-gray-900 mb-2">
                                   {{ $order->status === 'cancelled' ? 'Đơn Hàng Đã Bị Hủy' : 'Đã Hoàn Tiền' }}
                              </h3>
                              <p class="text-gray-500">
                                   Cập nhật lúc: {{ $order->updated_at->format('d/m/Y H:i') }}
                              </p>
                         </div>
                         @endif
                    </div>
               </div>
               
               <!-- Order Items -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6">Sản Phẩm Đã Đặt</h2>
                    
                    <div class="space-y-4">
                         @foreach($order->orderDetails as $detail)
                         <div class="flex gap-4 p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                              <img src="{{ $detail->product_image }}" 
                                   alt="{{ $detail->product_name }}"
                                   class="w-24 h-24 object-cover rounded-lg flex-shrink-0">
                              
                              <div class="flex-1">
                                   <h3 class="font-semibold text-gray-800 mb-2">{{ $detail->product_name }}</h3>
                                   
                                   <div class="text-sm text-gray-500 space-y-1">
                                        @if($detail->size || $detail->color)
                                             <div>
                                             Phân loại: 
                                             @if($detail->size)<span class="font-medium">Size {{ $detail->size }}</span>@endif
                                             @if($detail->size && $detail->color) | @endif
                                             @if($detail->color)<span class="font-medium">Màu {{ $detail->color }}</span>@endif
                                             </div>
                                        @endif
                                        <div>Số lượng: <span class="font-medium">{{ $detail->quantity }}</span></div>
                                        <div>Đơn giá: <span class="font-medium text-blue-600">{{ number_format($detail->price, 0, ',', '.') }}đ</span></div>
                                   </div>
                              </div>
                              
                              <div class="text-right flex-shrink-0">
                                   <div class="text-lg font-bold text-blue-600">
                                        {{ number_format($detail->total, 0, ',', '.') }}đ
                                   </div>
                              </div>
                         </div>
                         @endforeach
                    </div>
               </div>
               
               <!-- Payment Transactions (if any) -->
               @if($order->paymentTransactions->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                         <h2 class="text-xl font-bold mb-6">Lịch Sử Thanh Toán</h2>
                         
                         <div class="space-y-3">
                         @foreach($order->paymentTransactions as $transaction)
                              <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                   <div>
                                        <div class="font-semibold">{{ $transaction->transaction_id }}</div>
                                        <div class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                                   </div>
                                   
                                   <div class="text-right">
                                        <div class="font-bold text-blue-600">{{ number_format($transaction->amount, 0, ',', '.') }}đ</div>
                                        @php
                                             $txStatusColors = [
                                             'pending' => 'bg-yellow-100 text-yellow-800',
                                             'success' => 'bg-green-100 text-green-800',
                                             'failed' => 'bg-red-100 text-red-800',
                                             ];
                                        @endphp
                                        <span class="inline-block mt-1 px-2 py-1 rounded-full text-xs font-semibold {{ $txStatusColors[$transaction->status] }}">
                                             {{ ucfirst($transaction->status) }}
                                        </span>
                                   </div>
                              </div>
                         @endforeach
                         </div>
                    </div>
               @endif
          </div>
          
          <!-- Sidebar -->
          <div class="lg:col-span-1 space-y-6">
               <!-- Customer Info -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold mb-4">
                         <i class="fas fa-user text-blue-600 mr-2"></i>
                         Thông Tin Khách Hàng
                    </h2>
                    
                    <div class="space-y-3 text-sm">
                         <div>
                         <div class="text-gray-500 mb-1">Họ tên</div>
                         <div class="font-semibold">{{ $order->customer_name }}</div>
                         </div>
                         
                         <div>
                         <div class="text-gray-500 mb-1">Email</div>
                         <div class="font-semibold">{{ $order->customer_email }}</div>
                         </div>
                         
                         <div>
                         <div class="text-gray-500 mb-1">Số điện thoại</div>
                         <div class="font-semibold">{{ $order->customer_phone }}</div>
                         </div>
                         
                         <div>
                         <div class="text-gray-500 mb-1">Địa chỉ giao hàng</div>
                         <div class="font-semibold">{{ $order->customer_address }}</div>
                         </div>
                         
                         @if($order->notes)
                         <div>
                              <div class="text-gray-500 mb-1">Ghi chú</div>
                              <div class="font-semibold italic text-gray-700">{{ $order->notes }}</div>
                         </div>
                         @endif
                    </div>
               </div>
               
               <!-- Payment Info -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold mb-4">
                         <i class="fas fa-credit-card text-blue-600 mr-2"></i>
                         Thanh Toán
                    </h2>
                    
                    <div class="space-y-3 text-sm">
                         <div class="flex justify-between">
                         <span class="text-gray-500">Phương thức:</span>
                         <span class="font-semibold">
                              @if($order->payment_method === 'cod')
                                   <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>
                                   Thanh toán khi nhận hàng
                              @else
                                   <i class="fas fa-wallet text-pink-600 mr-1"></i>
                                   Momo
                              @endif
                         </span>
                         </div>
                         
                         <div class="flex justify-between">
                         <span class="text-gray-500">Trạng thái:</span>
                         @php
                              $paymentStatusColors = [
                                   'pending' => 'bg-yellow-100 text-yellow-800',
                                   'paid' => 'bg-green-100 text-green-800',
                                   'failed' => 'bg-red-100 text-red-800',
                              ];
                              
                              $paymentStatusLabels = [
                                   'pending' => 'Chờ thanh toán',
                                   'paid' => 'Đã thanh toán',
                                   'failed' => 'Thất bại',
                              ];
                         @endphp
                         <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $paymentStatusColors[$order->payment_status] }}">
                              {{ $paymentStatusLabels[$order->payment_status] }}
                         </span>
                         </div>
                         
                         @if($order->payment_code)
                         <div class="flex justify-between">
                              <span class="text-gray-500">Mã thanh toán:</span>
                              <span class="font-semibold">{{ $order->payment_code }}</span>
                         </div>
                         @endif
                    </div>
               </div>
               
               <!-- Order Summary -->
               <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-bold mb-4">
                         <i class="fas fa-receipt text-blue-600 mr-2"></i>
                         Tổng Cộng
                    </h2>
                    
                    <div class="space-y-3">
                         <div class="flex justify-between text-sm">
                         <span class="text-gray-600">Tạm tính:</span>
                         <span class="font-semibold">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                         </div>
                         
                         <div class="flex justify-between text-sm">
                         <span class="text-gray-600">Phí vận chuyển:</span>
                         <span class="font-semibold">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
                         </div>
                         
                         @if($order->discount_amount > 0)
                         <div class="flex justify-between text-sm text-green-600">
                              <span>Giảm giá:</span>
                              <span class="font-semibold">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                         </div>
                         
                         @if($order->coupon)
                              <div class="p-2 bg-green-50 rounded text-xs text-green-700">
                                   <i class="fas fa-tag mr-1"></i>
                                   Mã: <span class="font-semibold">{{ $order->coupon->code }}</span>
                              </div>
                         @endif
                         @endif
                         
                         <div class="border-t border-gray-200 pt-3 flex justify-between">
                         <span class="text-lg font-bold">Tổng cộng:</span>
                         <span class="text-2xl font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                         </div>
                    </div>
               </div>
               
               <!-- Support -->
               <div class="bg-blue-50 rounded-lg p-6 text-center">
                    <i class="fas fa-headset text-4xl text-blue-600 mb-3"></i>
                    <h3 class="font-bold mb-2">Cần Hỗ Trợ?</h3>
                    <p class="text-sm text-gray-600 mb-4">
                         Liên hệ với chúng tôi nếu bạn có bất kỳ thắc mắc nào
                    </p>
                    <a href="{{ route('contact') }}" 
                    class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                         <i class="fas fa-phone mr-2"></i>
                         Liên Hệ Ngay
                    </a>
               </div>
          </div>
     </div>
</div>

@push('styles')
<style>
     @media print {
          body * {
               visibility: hidden;
          }
          .print-area, .print-area * {
               visibility: visible;
          }
          .print-area {
               position: absolute;
               left: 0;
               top: 0;
               width: 100%;
          }
          .no-print {
               display: none !important;
          }
     }
</style>
@endpush
@endsection