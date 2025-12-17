@extends('layouts.admin')

@section('title', 'Chi Tiết Đơn Hàng - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div class="flex items-center gap-3">
               <a href="{{ route('admin.orders.index') }}" 
                    class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left text-xl"></i>
               </a>
               <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $order->order_code }}</h1>
                    <p class="text-gray-600 mt-1">Chi tiết thông tin đơn hàng</p>
               </div>
          </div>
          
          <div class="flex gap-2">
               <a href="{{ route('admin.orders.print', $order->id) }}" 
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-print mr-2"></i>
                    In Hóa Đơn
               </a>
               
               @if($order->status == 'cancelled')
               <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                    method="POST" 
                    class="inline"
                    onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA ĐƠN HÀNG NÀY?\n\nHành động này không thể hoàn tác!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                         class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                         <i class="fas fa-trash mr-2"></i>
                         Xóa Đơn
                    </button>
               </form>
               @endif
          </div>
     </div>
</div>

<!-- Order Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Tiền</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($order->total_amount, 0, ',', '.') }}đ</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Số Sản Phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $order->orderDetails->sum('quantity') }}</h3>
               </div>
               <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-2xl text-purple-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Phí Vận Chuyển</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-truck text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Giảm Giá</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ number_format($order->discount_amount, 0, ',', '.') }}đ</h3>
               </div>
               <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-tag text-2xl text-orange-600"></i>
               </div>
          </div>
     </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
     <!-- Main Content -->
     <div class="lg:col-span-2 space-y-6">
          <!-- Customer Info -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Thông Tin Khách Hàng
               </h2>
               
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                         Họ Tên
                         </label>
                         <div class="text-lg font-bold text-gray-900">{{ $order->customer_name }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-phone text-green-600 mr-2"></i>
                         Số Điện Thoại
                         </label>
                         <div class="text-gray-900">{{ $order->customer_phone }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-envelope text-red-600 mr-2"></i>
                         Email
                         </label>
                         <div class="text-gray-900">{{ $order->customer_email }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                         Địa Chỉ
                         </label>
                         <div class="text-gray-900">{{ $order->customer_address }}</div>
                    </div>
                    
                    @if($order->user)
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-id-card text-indigo-600 mr-2"></i>
                         Tài Khoản
                         </label>
                         <div class="text-gray-900">
                         <a href="{{ route('admin.users.show', $order->user_id) }}" class="text-blue-600 hover:underline">
                              {{ $order->user->name }} (ID: {{ $order->user_id }})
                         </a>
                         </div>
                    </div>
                    @endif
               </div>
          </div>

          <!-- Order Details -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                         <i class="fas fa-shopping-bag text-blue-600 mr-2"></i>
                         Sản Phẩm Đã Đặt ({{ $order->orderDetails->count() }})
                    </h2>
               </div>
               
               <div class="divide-y divide-gray-200">
                    @foreach($order->orderDetails as $detail)
                    <div class="p-4 hover:bg-gray-50 transition">
                         <div class="flex items-center gap-4">
                         @if($detail->product_image)
                              <img src="{{ asset('storage/' . $detail->product_image) }}" 
                                   alt="{{ $detail->product_name }}"
                                   class="w-20 h-20 object-cover rounded-lg flex-shrink-0 border border-gray-200">
                         @else
                              <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                   <i class="fas fa-image text-gray-400 text-2xl"></i>
                              </div>
                         @endif
                         
                         <div class="flex-1 min-w-0">
                              <div class="font-semibold text-gray-900 mb-1">{{ $detail->product_name }}</div>
                              
                              <div class="flex items-center gap-3 text-sm">
                                   @if($detail->size)
                                   <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded">
                                        <i class="fas fa-ruler mr-1"></i>
                                        {{ $detail->size }}
                                   </span>
                                   @endif
                                   
                                   @if($detail->color)
                                   <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded">
                                        <i class="fas fa-palette mr-1"></i>
                                        {{ $detail->color }}
                                   </span>
                                   @endif
                                   
                                   <span class="text-gray-600">
                                        <i class="fas fa-times mr-1"></i>
                                        {{ $detail->quantity }}
                                   </span>
                                   
                                   <span class="text-blue-600 font-semibold">
                                        {{ number_format($detail->price, 0, ',', '.') }}đ
                                   </span>
                              </div>
                         </div>
                         
                         <div class="flex-shrink-0 text-right">
                              <div class="text-lg font-bold text-gray-900">
                                   {{ number_format($detail->total, 0, ',', '.') }}đ
                              </div>
                         </div>
                         </div>
                    </div>
                    @endforeach
               </div>
               
               <!-- Order Summary -->
               <div class="bg-gray-50 p-6 border-t border-gray-200">
                    <div class="space-y-3 max-w-md ml-auto">
                         <div class="flex justify-between text-sm">
                         <span class="text-gray-600">Tạm tính:</span>
                         <span class="font-semibold text-gray-900">{{ number_format($order->subtotal, 0, ',', '.') }}đ</span>
                         </div>
                         
                         <div class="flex justify-between text-sm">
                         <span class="text-gray-600">Phí vận chuyển:</span>
                         <span class="font-semibold text-gray-900">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
                         </div>
                         
                         @if($order->discount_amount > 0)
                         <div class="flex justify-between text-sm">
                         <span class="text-gray-600">
                              Giảm giá:
                              @if($order->coupon)
                                   <span class="text-green-600 font-semibold">({{ $order->coupon->code }})</span>
                              @endif
                         </span>
                         <span class="font-semibold text-green-600">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                         </div>
                         @endif
                         
                         <div class="flex justify-between text-lg pt-3 border-t-2 border-blue-600">
                         <span class="font-bold text-gray-900">Tổng cộng:</span>
                         <span class="font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                         </div>
                    </div>
               </div>
          </div>

          <!-- Payment Transactions -->
          @if($order->paymentTransactions->count() > 0)
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                         <i class="fas fa-credit-card text-blue-600 mr-2"></i>
                         Lịch Sử Giao Dịch ({{ $order->paymentTransactions->count() }})
                    </h2>
               </div>
               
               <div class="divide-y divide-gray-200">
                    @foreach($order->paymentTransactions as $transaction)
                    <div class="p-4 hover:bg-gray-50 transition">
                         <div class="flex items-center justify-between">
                         <div class="flex-1">
                              <div class="font-semibold text-gray-900 mb-1">
                                   {{ $transaction->transaction_id }}
                              </div>
                              <div class="flex items-center gap-3 text-sm">
                                   <span class="text-gray-600">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                   </span>
                                   
                                   @if($transaction->payment_method == 'momo')
                                   <span class="text-pink-600">
                                        <i class="fab fa-cc-visa mr-1"></i>
                                        MoMo
                                   </span>
                                   @elseif($transaction->payment_method == 'cod')
                                   <span class="text-green-600">
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        COD
                                   </span>
                                   @endif
                                   
                                   @if($transaction->momo_trans_id)
                                   <span class="text-gray-500 text-xs">
                                        MoMo ID: {{ $transaction->momo_trans_id }}
                                   </span>
                                   @endif
                              </div>
                         </div>
                         
                         <div class="text-right">
                              <div class="font-bold text-blue-600 mb-1">
                                   {{ number_format($transaction->amount, 0, ',', '.') }}đ
                              </div>
                              @if($transaction->status == 'success')
                                   <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-check mr-1"></i>Thành công
                                   </span>
                              @elseif($transaction->status == 'pending')
                                   <span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-clock mr-1"></i>Đang xử lý
                                   </span>
                              @elseif($transaction->status == 'failed')
                                   <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                        <i class="fas fa-times mr-1"></i>Thất bại
                                   </span>
                              @endif
                         </div>
                         </div>
                         
                         @if($transaction->error_message)
                         <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded">
                         <i class="fas fa-exclamation-circle mr-1"></i>
                         {{ $transaction->error_message }}
                         </div>
                         @endif
                    </div>
                    @endforeach
               </div>
          </div>
          @endif

          <!-- Notes -->
          @if($order->notes)
          <div class="bg-white rounded-lg shadow-md p-6">
               <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-sticky-note text-blue-600 mr-2"></i>
                    Ghi Chú
               </h2>
               <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <p class="text-gray-700">{{ $order->notes }}</p>
               </div>
          </div>
          @endif
     </div>

     <!-- Sidebar -->
     <div class="lg:col-span-1 space-y-6">
          <!-- Order Status -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-list-alt text-blue-600 mr-2"></i>
                    Trạng Thái Đơn Hàng
               </h3>
               
               <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái hiện tại:</label>
                         <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                              <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                              <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                              <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                              <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                              <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                              <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                         </select>
                         </div>
                         
                         <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-save mr-2"></i>
                         Cập Nhật Trạng Thái
                         </button>
                    </div>
               </form>
          </div>

          <!-- Payment Status -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-credit-card text-green-600 mr-2"></i>
                    Trạng Thái Thanh Toán
               </h3>
               
               <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                         <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-2">Thanh toán:</label>
                         <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                              <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                              <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                              <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Thất bại</option>
                              <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                         </select>
                         </div>
                         
                         <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                         <i class="fas fa-save mr-2"></i>
                         Cập Nhật Thanh Toán
                         </button>
                    </div>
               </form>
          </div>

          <!-- Order Info -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                    Thông Tin Đơn Hàng
               </h3>
               
               <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Mã đơn:</span>
                         <span class="font-semibold text-gray-900">{{ $order->order_code }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Phương thức:</span>
                         <span class="font-semibold">
                         @if($order->payment_method == 'cod')
                              <span class="text-green-600">COD</span>
                         @elseif($order->payment_method == 'momo')
                              <span class="text-pink-600">MoMo</span>
                         @endif
                         </span>
                    </div>
                    
                    @if($order->payment_code)
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Mã thanh toán:</span>
                         <span class="font-semibold text-gray-900">{{ $order->payment_code }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                         <span class="text-gray-600">Ngày tạo:</span>
                         <span class="font-semibold text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                         <span class="text-gray-600">Cập nhật:</span>
                         <span class="font-semibold text-gray-900">{{ $order->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
               </div>
          </div>

          <!-- Quick Actions -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Thao Tác Nhanh
               </h3>
               
               <div class="space-y-2">
                    <a href="{{ route('admin.orders.print', $order->id) }}" 
                         target="_blank"
                         class="block p-3 bg-green-50 hover:bg-green-100 rounded-lg transition text-sm font-semibold text-green-700">
                         <i class="fas fa-print mr-2"></i>
                         In Hóa Đơn
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                         class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-sm font-semibold text-blue-700">
                         <i class="fas fa-list mr-2"></i>
                         Tất Cả Đơn Hàng
                    </a>
                    
                    @if($order->user)
                    <a href="{{ route('admin.users.show', $order->user_id) }}" 
                         class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-sm font-semibold text-purple-700">
                         <i class="fas fa-user mr-2"></i>
                         Xem Khách Hàng
                    </a>
                    @endif
               </div>
          </div>

          <!-- Order Timeline -->
          <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
               <h3 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Thời Gian
               </h3>
               
               <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-2">
                         <i class="fas fa-plus-circle"></i>
                         <span class="opacity-90">Tạo đơn:</span>
                         <span class="font-semibold ml-auto">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                         <i class="fas fa-edit"></i>
                         <span class="opacity-90">Cập nhật:</span>
                         <span class="font-semibold ml-auto">{{ $order->updated_at->diffForHumans() }}</span>
                    </div>
               </div>
          </div>
     </div>
</div>
@endsection