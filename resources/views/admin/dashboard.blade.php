@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600 mt-1">Tổng quan hoạt động kinh doanh</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
     <!-- Total Orders -->
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Đơn Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalOrders) }}</h3>
                    <p class="text-sm text-blue-600 mt-2">
                         <i class="fas fa-arrow-up mr-1"></i>
                         +{{ $todayOrders }} hôm nay
                    </p>
               </div>
               <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-3xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <!-- Total Revenue -->
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Doanh Thu</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
                    <p class="text-sm text-green-600 mt-2">
                         <i class="fas fa-arrow-up mr-1"></i>
                         +{{ number_format($todayRevenue, 0, ',', '.') }}đ hôm nay
                    </p>
               </div>
               <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-3xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <!-- Total Products -->
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Sản Phẩm</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</h3>
                    <p class="text-sm text-purple-600 mt-2">
                         <i class="fas fa-box mr-1"></i>
                         Đang kinh doanh
                    </p>
               </div>
               <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-3xl text-purple-600"></i>
               </div>
          </div>
     </div>
    
     <!-- Total Users -->
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Khách Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalUsers) }}</h3>
                    <p class="text-sm text-yellow-600 mt-2">
                         <i class="fas fa-users mr-1"></i>
                         Thành viên
                    </p>
               </div>
               <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-3xl text-yellow-600"></i>
               </div>
          </div>
     </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Revenue Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
            Doanh Thu 7 Ngày Gần Nhất
        </h2>
        <div style="position: relative; height: 300px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    
    <!-- Order Status Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
            Trạng Thái Đơn Hàng
        </h2>
        <div style="position: relative; height: 300px;">
            <canvas id="orderStatusChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Orders & Top Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
     <!-- Recent Orders -->
     <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center justify-between mb-4">
               <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-clock text-blue-600 mr-2"></i>
                    Đơn Hàng Gần Nhất
               </h2>
               <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
               </a>
          </div>
          
          <div class="space-y-3">
               @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                         <div class="flex items-center gap-3 flex-1">
                         <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                              <i class="fas fa-shopping-bag text-blue-600"></i>
                         </div>
                         <div class="flex-1 min-w-0">
                              <div class="flex items-center gap-2">
                                   <a href="{{ route('admin.orders.show', $order->id) }}" class="font-semibold text-gray-900 hover:text-blue-600 truncate">
                                        {{ $order->order_code }}
                                   </a>
                                   @php
                                        $statusColors = [
                                             'pending' => 'bg-yellow-100 text-yellow-800',
                                             'confirmed' => 'bg-blue-100 text-blue-800',
                                             'processing' => 'bg-purple-100 text-purple-800',
                                             'shipping' => 'bg-indigo-100 text-indigo-800',
                                             'delivered' => 'bg-green-100 text-green-800',
                                             'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                   @endphp
                                   <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->status) }}
                                   </span>
                              </div>
                              <div class="text-xs text-gray-500 mt-1">
                                   {{ $order->customer_name }} • {{ $order->created_at->diffForHumans() }}
                              </div>
                         </div>
                         </div>
                         <div class="text-right flex-shrink-0 ml-3">
                         <div class="font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }}đ</div>
                         </div>
                    </div>
               @empty
                    <div class="text-center py-8 text-gray-500">
                         <i class="fas fa-inbox text-4xl mb-2"></i>
                         <p>Chưa có đơn hàng nào</p>
                    </div>
               @endforelse
          </div>
     </div>
    
     <!-- Top Products -->
     <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center justify-between mb-4">
               <h2 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-fire text-orange-600 mr-2"></i>
                    Sản Phẩm Bán Chạy
               </h2>
               <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    Xem tất cả <i class="fas fa-arrow-right ml-1"></i>
               </a>
          </div>
          
          <div class="space-y-3">
               @forelse($topProducts as $product)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                         <img src="{{ $product->main_image_url }}" 
                              alt="{{ $product->product_name }}"
                              class="w-14 h-14 object-cover rounded-lg flex-shrink-0">
                         <div class="flex-1 min-w-0">
                         <a href="{{ route('admin.products.show', $product->id) }}" class="font-semibold text-gray-900 hover:text-blue-600 block truncate">
                              {{ $product->product_name }}
                         </a>
                         <div class="flex items-center gap-2 mt-1">
                              <span class="text-sm text-gray-600">
                                   <i class="fas fa-shopping-cart text-blue-600 mr-1"></i>
                                   {{ $product->order_details_count }} đã bán
                              </span>
                              <span class="text-xs text-gray-400">•</span>
                              <span class="text-sm text-gray-600">
                                   <i class="fas fa-box text-green-600 mr-1"></i>
                                   {{ $product->total_stock }} còn lại
                              </span>
                         </div>
                         </div>
                    </div>
               @empty
                    <div class="text-center py-8 text-gray-500">
                         <i class="fas fa-box-open text-4xl mb-2"></i>
                         <p>Chưa có dữ liệu</p>
                    </div>
               @endforelse
          </div>
     </div>
</div>

<!-- Low Stock Products -->
@if($lowStockProducts->count() > 0)
     <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-6">
          <div class="flex items-start gap-3">
               <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-2xl text-yellow-600"></i>
               </div>
               <div class="flex-1">
                    <h3 class="font-bold text-gray-900 mb-2">
                         <i class="fas fa-box text-yellow-600 mr-2"></i>
                         Cảnh Báo Tồn Kho Thấp ({{ $lowStockProducts->count() }} sản phẩm)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                         @foreach($lowStockProducts as $product)
                         <div class="bg-white rounded-lg p-3 border border-yellow-200">
                              <div class="flex items-center gap-2">
                                   <img src="{{ $product->main_image_url }}" 
                                        alt="{{ $product->product_name }}"
                                        class="w-10 h-10 object-cover rounded flex-shrink-0">
                                   <div class="flex-1 min-w-0">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600 block truncate">
                                             {{ $product->product_name }}
                                        </a>
                                        <div class="text-xs text-red-600 font-semibold">
                                             <i class="fas fa-exclamation-circle mr-1"></i>
                                             Còn {{ $product->attributes->sum('quantity') }} sản phẩm
                                        </div>
                                   </div>
                              </div>
                         </div>
                         @endforeach
                    </div>
               </div>
          </div>
     </div>
@endif

@push('scripts')
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart');
if (revenueCtx) {
     const revenueChart = new Chart(revenueCtx, {
          type: 'line',
          data: {
               labels: {!! json_encode(array_column($last7Days, 'date')) !!},
               datasets: [{
                    label: 'Doanh Thu (đ)',
                    data: {!! json_encode(array_column($last7Days, 'revenue')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
               }]
          },
          options: {
               responsive: true,
               maintainAspectRatio: false, // ✅ QUAN TRỌNG
               plugins: {
                    legend: {
                         display: false
                    },
                    tooltip: {
                         callbacks: {
                         label: function(context) {
                              return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + 'đ';
                         }
                         }
                    }
               },
               scales: {
                    y: {
                         beginAtZero: true,
                         ticks: {
                         callback: function(value) {
                              if (value >= 1000000) {
                                   return (value / 1000000).toFixed(1) + 'M';
                              }
                              if (value >= 1000) {
                                   return (value / 1000).toFixed(0) + 'K';
                              }
                              return value;
                         }
                         }
                    }
               }
          }
     });
}

// Order Status Chart
const orderStatusCtx = document.getElementById('orderStatusChart');
if (orderStatusCtx) {
     const orderStatusChart = new Chart(orderStatusCtx, {
          type: 'doughnut',
          data: {
               labels: ['Chờ xác nhận', 'Đã xác nhận', 'Đang xử lý', 'Đang giao', 'Đã giao', 'Đã hủy'],
               datasets: [{
                    data: [
                         {{ $ordersByStatus['pending'] ?? 0 }},
                         {{ $ordersByStatus['confirmed'] ?? 0 }},
                         {{ $ordersByStatus['processing'] ?? 0 }},
                         {{ $ordersByStatus['shipping'] ?? 0 }},
                         {{ $ordersByStatus['delivered'] ?? 0 }},
                         {{ $ordersByStatus['cancelled'] ?? 0 }}
                    ],
                    backgroundColor: [
                         'rgb(234, 179, 8)',   // yellow - pending
                         'rgb(59, 130, 246)',  // blue - confirmed
                         'rgb(168, 85, 247)',  // purple - processing
                         'rgb(99, 102, 241)',  // indigo - shipping
                         'rgb(34, 197, 94)',   // green - delivered
                         'rgb(239, 68, 68)'    // red - cancelled
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
               }]
          },
          options: {
               responsive: true,
               maintainAspectRatio: false, // ✅ QUAN TRỌNG
               plugins: {
                    legend: {
                         position: 'bottom',
                         labels: {
                         padding: 15,
                         font: {
                              size: 12
                         }
                         }
                    },
                    tooltip: {
                         callbacks: {
                         label: function(context) {
                              const label = context.label || '';
                              const value = context.parsed || 0;
                              const total = context.dataset.data.reduce((a, b) => a + b, 0);
                              const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                              return label + ': ' + value + ' (' + percentage + '%)';
                         }
                         }
                    }
               }
          }
     });
}
</script>
@endpush
@endsection