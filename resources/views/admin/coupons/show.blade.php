@extends('layouts.admin')

@section('title', 'Chi Tiết Mã Giảm Giá - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div class="flex items-center gap-3">
               <a href="{{ route('admin.coupons.index') }}" 
                    class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left text-xl"></i>
               </a>
               <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $coupon->code }}</h1>
                    <p class="text-gray-600 mt-1">Chi tiết thông tin mã giảm giá</p>
               </div>
          </div>
          
          <div class="flex gap-2">
               <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-semibold">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh Sửa
               </a>
               
               <form action="{{ route('admin.coupons.toggle-status', $coupon->id) }}" 
                    method="POST" 
                    class="inline">
                    @csrf
                    <button type="submit" 
                         class="inline-flex items-center px-4 py-2 {{ $coupon->is_active ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition font-semibold">
                         <i class="fas {{ $coupon->is_active ? 'fa-power-off' : 'fa-check-circle' }} mr-2"></i>
                         {{ $coupon->is_active ? 'Vô Hiệu Hóa' : 'Kích Hoạt' }}
                    </button>
               </form>
               
               @if($coupon->orders()->count() == 0)
               <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" 
                    method="POST" 
                    class="inline"
                    onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA MÃ GIẢM GIÁ NÀY?\n\nHành động này không thể hoàn tác!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                         class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                         <i class="fas fa-trash mr-2"></i>
                         Xóa
                    </button>
               </form>
               @endif
          </div>
     </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Giá Trị Giảm</p>
                    <h3 class="text-2xl font-bold text-gray-900">
                         @if($coupon->type == 'percentage')
                         {{ $coupon->value }}%
                         @else
                         {{ number_format($coupon->value, 0, ',', '.') }}đ
                         @endif
                    </h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-{{ $coupon->type == 'percentage' ? 'percent' : 'dollar-sign' }} text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đã Sử Dụng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $coupon->used_count }}</h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Giới Hạn</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $coupon->usage_limit ?? '∞' }}</h3>
               </div>
               <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-hashtag text-2xl text-purple-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đơn Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $coupon->orders()->count() }}</h3>
               </div>
               <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-2xl text-orange-600"></i>
               </div>
          </div>
     </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
     <!-- Main Content -->
     <div class="lg:col-span-2 space-y-6">
          <!-- Coupon Info -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Thông Tin Mã Giảm Giá
               </h2>
               
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-tag text-blue-600 mr-2"></i>
                         Mã Code
                         </label>
                         <div class="text-lg font-bold text-gray-900">{{ $coupon->code }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-hashtag text-purple-600 mr-2"></i>
                         ID
                         </label>
                         <div class="text-lg font-bold text-gray-900">#{{ $coupon->id }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-{{ $coupon->type == 'percentage' ? 'percent' : 'dollar-sign' }} text-green-600 mr-2"></i>
                         Loại Giảm Giá
                         </label>
                         <div>
                         @if($coupon->type == 'percentage')
                         <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                              <i class="fas fa-percent mr-2"></i>Phần trăm
                         </span>
                         @else
                         <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                              <i class="fas fa-dollar-sign mr-2"></i>Cố định
                         </span>
                         @endif
                         </div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-gift text-yellow-600 mr-2"></i>
                         Giá Trị Giảm
                         </label>
                         <div class="text-lg font-bold text-blue-600">
                         @if($coupon->type == 'percentage')
                         {{ $coupon->value }}%
                         @else
                         {{ number_format($coupon->value, 0, ',', '.') }}đ
                         @endif
                         </div>
                    </div>
                    
                    @if($coupon->min_order_amount)
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-shopping-cart text-indigo-600 mr-2"></i>
                         Đơn Hàng Tối Thiểu
                         </label>
                         <div class="text-gray-900">{{ number_format($coupon->min_order_amount, 0, ',', '.') }}đ</div>
                    </div>
                    @endif
                    
                    @if($coupon->max_discount_amount && $coupon->type == 'percentage')
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-arrow-down text-orange-600 mr-2"></i>
                         Giảm Giá Tối Đa
                         </label>
                         <div class="text-gray-900">{{ number_format($coupon->max_discount_amount, 0, ',', '.') }}đ</div>
                    </div>
                    @endif
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-users text-pink-600 mr-2"></i>
                         Số Lần Sử Dụng
                         </label>
                         <div class="text-gray-900">
                         <span class="font-bold text-green-600">{{ $coupon->used_count }}</span>
                         @if($coupon->usage_limit)
                         / {{ $coupon->usage_limit }}
                         @else
                         / ∞
                         @endif
                         </div>
                         @if($coupon->usage_limit)
                         @php
                         $percentage = ($coupon->used_count / $coupon->usage_limit) * 100;
                         @endphp
                         <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                         <div class="bg-green-600 h-2 rounded-full transition-all" style="width: {{ min($percentage, 100) }}%"></div>
                         </div>
                         @endif
                    </div>
                    
                    @if($coupon->usage_per_user)
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-user text-teal-600 mr-2"></i>
                         Giới Hạn/Người
                         </label>
                         <div class="text-gray-900">{{ $coupon->usage_per_user }} lần</div>
                    </div>
                    @endif
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-toggle-on text-green-600 mr-2"></i>
                         Trạng Thái
                         </label>
                         <div>
                         @if($coupon->isValid())
                         <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                              <i class="fas fa-check-circle mr-2"></i>Hợp lệ
                         </span>
                         @else
                              @if(!$coupon->is_active)
                              <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                   <i class="fas fa-power-off mr-2"></i>Đã tắt
                              </span>
                              @elseif($coupon->start_date && now()->lt($coupon->start_date))
                              <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                   <i class="fas fa-clock mr-2"></i>Chưa bắt đầu
                              </span>
                              @elseif($coupon->end_date && now()->gt($coupon->end_date))
                              <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                   <i class="fas fa-calendar-times mr-2"></i>Hết hạn
                              </span>
                              @elseif($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit)
                              <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">
                                   <i class="fas fa-ban mr-2"></i>Hết lượt
                              </span>
                              @endif
                         @endif
                         </div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-calendar-plus text-green-600 mr-2"></i>
                         Ngày Tạo
                         </label>
                         <div class="text-gray-900">{{ $coupon->created_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $coupon->created_at->diffForHumans() }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-clock text-yellow-600 mr-2"></i>
                         Cập Nhật Lần Cuối
                         </label>
                         <div class="text-gray-900">{{ $coupon->updated_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $coupon->updated_at->diffForHumans() }}</div>
                    </div>
               </div>
          </div>
          
          <!-- Validity Period -->
          @if($coupon->start_date || $coupon->end_date)
          <div class="bg-white rounded-lg shadow-md p-6">
               <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                    Thời Gian Hiệu Lực
               </h2>
               
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($coupon->start_date)
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="far fa-calendar-plus text-green-600 mr-2"></i>
                         Ngày Bắt Đầu
                         </label>
                         <div class="text-gray-900 font-semibold">{{ $coupon->start_date->format('d/m/Y') }}</div>
                         <div class="text-xs text-gray-500 mt-1">
                         @if($coupon->start_date->isFuture())
                         Sẽ bắt đầu {{ $coupon->start_date->diffForHumans() }}
                         @else
                         Đã bắt đầu {{ $coupon->start_date->diffForHumans() }}
                         @endif
                         </div>
                    </div>
                    @else
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="far fa-calendar-plus text-green-600 mr-2"></i>
                         Ngày Bắt Đầu
                         </label>
                         <div class="text-gray-400 italic">Không giới hạn</div>
                    </div>
                    @endif
                    
                    @if($coupon->end_date)
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="far fa-calendar-times text-red-600 mr-2"></i>
                         Ngày Kết Thúc
                         </label>
                         <div class="text-gray-900 font-semibold {{ $coupon->end_date->isPast() ? 'text-red-600' : '' }}">
                         {{ $coupon->end_date->format('d/m/Y') }}
                         </div>
                         <div class="text-xs mt-1 {{ $coupon->end_date->isPast() ? 'text-red-600' : 'text-gray-500' }}">
                         @if($coupon->end_date->isPast())
                         Đã hết hạn {{ $coupon->end_date->diffForHumans() }}
                         @else
                         Còn {{ $coupon->end_date->diffForHumans() }}
                         @endif
                         </div>
                    </div>
                    @else
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="far fa-calendar-times text-red-600 mr-2"></i>
                         Ngày Kết Thúc
                         </label>
                         <div class="text-gray-400 italic">Không giới hạn</div>
                    </div>
                    @endif
               </div>
          </div>
          @endif
          
          <!-- Recent Orders -->
          @if($coupon->orders->count() > 0)
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                         <h2 class="text-xl font-bold text-gray-900 flex items-center">
                         <i class="fas fa-shopping-cart text-blue-600 mr-2"></i>
                         Đơn Hàng Sử Dụng Mã ({{ $coupon->orders()->count() }})
                         </h2>
                    </div>
               </div>
               
               <div class="divide-y divide-gray-200">
                    @foreach($coupon->orders as $order)
                    <div class="p-4 hover:bg-gray-50 transition">
                         <div class="flex items-center justify-between gap-4">
                         <div class="flex-1">
                              <div class="flex items-center gap-3 mb-2">
                                   <a href="{{ route('admin.orders.show', $order->id) }}" 
                                        class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $order->order_code }}
                                   </a>
                                   
                                   @if($order->status == 'completed')
                                   <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Đã giao
                                   </span>
                                   @elseif($order->status == 'cancelled')
                                   <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-ban mr-1"></i>Đã hủy
                                   </span>
                                   @elseif($order->status == 'pending')
                                   <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Chờ xác nhận
                                   </span>
                                   @endif
                              </div>
                              
                              <div class="flex items-center gap-4 text-sm text-gray-600">
                                   <span>
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $order->customer_name }}
                                   </span>
                                   <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                   </span>
                                   <span class="text-green-600 font-semibold">
                                        <i class="fas fa-tag mr-1"></i>
                                        -{{ number_format($order->discount_amount, 0, ',', '.') }}đ
                                   </span>
                              </div>
                         </div>
                         
                         <div class="text-right">
                              <div class="text-lg font-bold text-blue-600">
                                   {{ number_format($order->total_amount, 0, ',', '.') }}đ
                              </div>
                         </div>
                         </div>
                    </div>
                    @endforeach
               </div>
               
               @if($coupon->orders()->count() > 10)
               <div class="px-6 py-4 bg-gray-50 text-center">
                    <p class="text-sm text-gray-600">
                         Hiển thị 10 đơn hàng gần nhất. Tổng cộng: <strong>{{ $coupon->orders()->count() }}</strong> đơn hàng
                    </p>
               </div>
               @endif
          </div>
          @else
          <div class="bg-white rounded-lg shadow-md p-12">
               <div class="text-center">
                    <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
                         <i class="fas fa-shopping-cart text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa Có Đơn Hàng</h3>
                    <p class="text-gray-600">Mã giảm giá này chưa được sử dụng trong bất kỳ đơn hàng nào</p>
               </div>
          </div>
          @endif
     </div>
    
     <!-- Sidebar -->
     <div class="lg:col-span-1 space-y-6">
          <!-- Coupon Card -->
          <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
               <h3 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Mã Giảm Giá
               </h3>
               
               <div class="bg-white/10 backdrop-blur rounded-lg p-4 mb-4">
                    <div class="text-center">
                         <div class="text-2xl font-bold mb-2">{{ $coupon->code }}</div>
                         <div class="text-sm opacity-90">
                         @if($coupon->type == 'percentage')
                         Giảm {{ $coupon->value }}%
                         @else
                         Giảm {{ number_format($coupon->value, 0, ',', '.') }}đ
                         @endif
                         </div>
                    </div>
               </div>
               
               <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                         <span class="opacity-90">Loại:</span>
                         <span class="font-semibold">{{ $coupon->type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</span>
                    </div>
                    @if($coupon->min_order_amount)
                    <div class="flex justify-between">
                         <span class="opacity-90">Đơn tối thiểu:</span>
                         <span class="font-semibold">{{ number_format($coupon->min_order_amount, 0, ',', '.') }}đ</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                         <span class="opacity-90">Đã sử dụng:</span>
                         <span class="font-semibold">{{ $coupon->used_count }} lần</span>
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
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                    class="block p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition text-sm font-semibold text-yellow-700">
                         <i class="fas fa-edit mr-2"></i>
                         Chỉnh Sửa Mã
                    </a>
                    
                    <form action="{{ route('admin.coupons.toggle-status', $coupon->id) }}" 
                         method="POST">
                         @csrf
                         <button type="submit" 
                              class="block w-full text-left p-3 {{ $coupon->is_active ? 'bg-gray-50 hover:bg-gray-100 text-gray-700' : 'bg-green-50 hover:bg-green-100 text-green-700' }} rounded-lg transition text-sm font-semibold">
                         <i class="fas {{ $coupon->is_active ? 'fa-power-off' : 'fa-check-circle' }} mr-2"></i>
                         {{ $coupon->is_active ? 'Vô Hiệu Hóa' : 'Kích Hoạt' }}
                         </button>
                    </form>
                    
                    <a href="{{ route('admin.coupons.index') }}" 
                    class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-sm font-semibold text-blue-700">
                         <i class="fas fa-list mr-2"></i>
                         Tất Cả Mã Giảm Giá
                    </a>
               </div>
          </div>
          
          <!-- Statistics -->
          <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-lg shadow-md p-6 text-white">
               <h3 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Thống Kê Chi Tiết
               </h3>
               
               <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Tổng đơn hàng:</span>
                         <span class="font-bold text-lg">{{ $coupon->orders()->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Đã sử dụng:</span>
                         <span class="font-bold text-lg">{{ $coupon->used_count }} lần</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Giới hạn:</span>
                         <span class="font-bold text-lg">{{ $coupon->usage_limit ?? '∞' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                         <span class="text-sm opacity-90">Tổng giảm giá:</span>
                         <span class="font-bold text-lg">{{ number_format($coupon->orders()->sum('discount_amount'), 0, ',', '.') }}đ</span>
                    </div>
               </div>
          </div>
          
          <!-- Delete Warning -->
          @if($coupon->orders()->count() == 0)
               <div class="bg-red-50 rounded-lg border-2 border-red-200 p-6">
                    <h3 class="font-bold text-red-900 mb-3 flex items-center">
                         <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                         Xóa Mã Giảm Giá
                    </h3>
                    <invoke name="artifacts">
                    <parameter name="command">update</parameter>
                    <parameter name="id">coupons_show_blade</parameter>
                    <parameter name="old_str">            
                         <h3 class="font-bold text-red-900 mb-3 flex items-center">
                         <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                         Xóa Mã Giảm Giá
                         </h3>
                    </parameter>
                    <parameter name="new_str">
                         <h3 class="font-bold text-red-900 mb-3 flex items-center">
                         <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                         Xóa Mã Giảm Giá
                         </h3>
                         <p class="text-sm text-red-700 mb-4">
                         Mã này chưa được sử dụng và có thể xóa. Hành động này không thể hoàn tác.
                         </p>
                         <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA MÃ GIẢM GIÁ NÀY?\n\nHành động này không thể hoàn tác!')">
                         @csrf
                         @method('DELETE')
                         <button type="submit" 
                              class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                              <i class="fas fa-trash-alt mr-2"></i>
                              Xóa Mã Giảm Giá
                         </button>
                         </form>
                    </parameter>
               </div>
          @endif
     </div>
</div>
@endsection     