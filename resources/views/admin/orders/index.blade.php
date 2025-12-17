@extends('layouts.admin')

@section('title', 'Quản Lý Đơn Hàng - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Quản Lý Đơn Hàng</h1>
               <p class="text-gray-600 mt-1">Quản lý và theo dõi tất cả đơn hàng</p>
          </div>
          
          <div class="flex gap-2">
               <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-semibold">
                    <i class="fas fa-print mr-2"></i>
                    In Danh Sách
               </button>
               
               <a href="{{ route('admin.orders.export') }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-file-excel mr-2"></i>
                    Xuất Excel
               </a>
          </div>
     </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Đơn Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ \App\Models\Order::count() }}</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Chờ Xác Nhận</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\Order::where('status', 'pending')->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đã Giao</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\Order::where('status', 'delivered')->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Doanh Thu</p>
                    <h3 class="text-2xl font-bold text-gray-900">
                         {{ number_format(\App\Models\Order::where('status', 'delivered')->sum('total_amount'), 0, ',', '.') }}đ
                    </h3>
               </div>
               <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-2xl text-purple-600"></i>
               </div>
          </div>
     </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
     <form action="{{ route('admin.orders.index') }}" method="GET" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
               <!-- Search -->
               <div class="lg:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-search text-blue-600 mr-1"></i>
                         Tìm Kiếm
                    </label>
                    <input type="text" 
                         name="search" 
                         value="{{ request('search') }}"
                         placeholder="Mã đơn, tên, email, số điện thoại..."
                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
               </div>
               
               <!-- Status Filter -->
               <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-filter text-green-600 mr-1"></i>
                         Trạng Thái Đơn
                    </label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         <option value="">Tất cả</option>
                         <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                         <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                         <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                         <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                         <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                         <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
               </div>
               
               <!-- Payment Status Filter -->
               <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-credit-card text-purple-600 mr-1"></i>
                         Thanh Toán
                    </label>
                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                         <option value="">Tất cả</option>
                         <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                         <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                         <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                         <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                    </select>
               </div>
               
               <!-- Actions -->
               <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-search mr-2"></i>
                         Lọc
                    </button>
                    <a href="{{ route('admin.orders.index') }}" 
                         class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold">
                         <i class="fas fa-redo"></i>
                    </a>
               </div>
          </div>
          
          <!-- Date Range Filter -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200">
               <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-calendar text-indigo-600 mr-1"></i>
                         Từ Ngày
                    </label>
                    <input type="date" 
                         name="date_from" 
                         value="{{ request('date_from') }}"
                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
               </div>
               
               <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-calendar text-indigo-600 mr-1"></i>
                         Đến Ngày
                    </label>
                    <input type="date" 
                         name="date_to" 
                         value="{{ request('date_to') }}"
                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
               </div>
          </div>
     </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
     <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
               <thead class="bg-gray-50">
                    <tr>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Mã Đơn
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Khách Hàng
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Tổng Tiền
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Thanh Toán
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Trạng Thái
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Ngày Tạo
                         </th>
                         <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Thao Tác
                         </th>
                    </tr>
               </thead>
               <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="flex items-center">
                              <div>
                                   <div class="font-semibold text-gray-900">{{ $order->order_code }}</div>
                                   <div class="text-xs text-gray-500">
                                        @if($order->payment_method == 'cod')
                                             <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>COD
                                        @elseif($order->payment_method == 'momo')
                                             <i class="fab fa-cc-visa text-pink-600 mr-1"></i>MoMo
                                        @endif
                                   </div>
                              </div>
                         </div>
                         </td>
                         <td class="px-6 py-4">
                         <div class="text-sm">
                              <div class="font-semibold text-gray-900">{{ $order->customer_name }}</div>
                              <div class="text-gray-500">{{ $order->customer_phone }}</div>
                              <div class="text-xs text-gray-400">{{ $order->customer_email }}</div>
                         </div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="text-sm font-bold text-blue-600">
                              {{ number_format($order->total_amount, 0, ',', '.') }}đ
                         </div>
                         @if($order->discount_amount > 0)
                         <div class="text-xs text-green-600">
                              -{{ number_format($order->discount_amount, 0, ',', '.') }}đ
                         </div>
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         @if($order->payment_status == 'pending')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                   <i class="fas fa-clock mr-1"></i>Chờ thanh toán
                              </span>
                         @elseif($order->payment_status == 'paid')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                   <i class="fas fa-check-circle mr-1"></i>Đã thanh toán
                              </span>
                         @elseif($order->payment_status == 'failed')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                   <i class="fas fa-times-circle mr-1"></i>Thất bại
                              </span>
                         @elseif($order->payment_status == 'refunded')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                   <i class="fas fa-undo mr-1"></i>Hoàn tiền
                              </span>
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         @if($order->status == 'pending')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                   <i class="fas fa-hourglass-half mr-1"></i>Chờ xác nhận
                              </span>
                         @elseif($order->status == 'confirmed')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                   <i class="fas fa-check mr-1"></i>Đã xác nhận
                              </span>
                         @elseif($order->status == 'processing')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                   <i class="fas fa-cog mr-1"></i>Đang xử lý
                              </span>
                         @elseif($order->status == 'shipping')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                   <i class="fas fa-shipping-fast mr-1"></i>Đang giao
                              </span>
                         @elseif($order->status == 'delivered')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                   <i class="fas fa-check-double mr-1"></i>Đã giao
                              </span>
                         @elseif($order->status == 'cancelled')
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                   <i class="fas fa-ban mr-1"></i>Đã hủy
                              </span>
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                         <div>{{ $order->created_at->format('d/m/Y') }}</div>
                         <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                         <div class="flex items-center justify-end gap-2">
                              <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded transition"
                                   title="Xem chi tiết">
                                   <i class="fas fa-eye"></i>
                              </a>
                              
                              <a href="{{ route('admin.orders.print', $order->id) }}" 
                                   target="_blank"
                                   class="text-green-600 hover:text-green-900 p-2 hover:bg-green-50 rounded transition"
                                   title="In đơn hàng">
                                   <i class="fas fa-print"></i>
                              </a>
                              
                              @if($order->status == 'cancelled')
                              <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                   method="POST" 
                                   class="inline"
                                   onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" 
                                        class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded transition"
                                        title="Xóa đơn hàng">
                                        <i class="fas fa-trash"></i>
                                   </button>
                              </form>
                              @endif
                         </div>
                         </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="7" class="px-6 py-12 text-center">
                         <div class="flex flex-col items-center justify-center">
                              <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                   <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                              </div>
                              <h3 class="text-lg font-semibold text-gray-900 mb-2">Không Tìm Thấy Đơn Hàng</h3>
                              <p class="text-gray-500">
                                   @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                                        Không có đơn hàng nào phù hợp với bộ lọc của bạn.
                                   @else
                                        Chưa có đơn hàng nào trong hệ thống.
                                   @endif
                              </p>
                              @if(request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                                   <a href="{{ route('admin.orders.index') }}" 
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-redo mr-2"></i>
                                        Xóa Bộ Lọc
                                   </a>
                              @endif
                         </div>
                         </td>
                    </tr>
                    @endforelse
               </tbody>
          </table>
     </div>
    
     <!-- Pagination -->
     @if($orders->hasPages())
     <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
          <div class="flex items-center justify-between">
               <div class="flex-1 flex justify-between sm:hidden">
                    @if ($orders->onFirstPage())
                         <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100">
                         Trước
                         </span>
                    @else
                         <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                         Trước
                         </a>
                    @endif

                    @if ($orders->hasMorePages())
                         <a href="{{ $orders->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                         Sau
                         </a>
                    @else
                         <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100">
                         Sau
                         </span>
                    @endif
               </div>
               <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                         <p class="text-sm text-gray-700">
                         Hiển thị
                         <span class="font-medium">{{ $orders->firstItem() ?? 0 }}</span>
                         đến
                         <span class="font-medium">{{ $orders->lastItem() ?? 0 }}</span>
                         trong tổng số
                         <span class="font-medium">{{ $orders->total() }}</span>
                         đơn hàng
                         </p>
                    </div>
                    <div>
                         {{ $orders->links() }}
                    </div>
               </div>
          </div>
     </div>
     @endif
</div>
@endsection