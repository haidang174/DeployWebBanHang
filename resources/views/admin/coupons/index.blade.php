@extends('layouts.admin')

@section('title', 'Quản Lý Mã Giảm Giá - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Quản Lý Mã Giảm Giá</h1>
               <p class="text-gray-600 mt-1">Tạo và quản lý các mã khuyến mãi</p>
          </div>
          
          <div class="flex gap-2">
               <a href="{{ route('admin.coupons.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-plus mr-2"></i>
                    Thêm Mã Giảm Giá
               </a>
          </div>
     </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Mã Giảm Giá</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ \App\Models\Coupon::count() }}</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đang Hoạt Động</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\Coupon::where('is_active', true)->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đã Sử Dụng</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\Coupon::sum('used_count') }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-yellow-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Hết Hạn</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\Coupon::where('end_date', '<', now())->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
               </div>
          </div>
     </div>
</div>

<!-- Coupons Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
     <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
               <thead class="bg-gray-50">
                    <tr>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Mã Code
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Loại & Giá Trị
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Điều Kiện
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Sử Dụng
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Thời Hạn
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Trạng Thái
                         </th>
                         <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Thao Tác
                         </th>
                    </tr>
               </thead>
               <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($coupons as $coupon)
                    <tr class="hover:bg-gray-50 transition">
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="flex items-center">
                              <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                   <i class="fas fa-tag text-white"></i>
                              </div>
                              <div class="ml-3">
                                   <div class="text-sm font-bold text-gray-900">{{ $coupon->code }}</div>
                                   <div class="text-xs text-gray-500">ID: {{ $coupon->id }}</div>
                              </div>
                         </div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="text-sm">
                              @if($coupon->type == 'percentage')
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-percent mr-1"></i>
                                        Phần trăm
                                   </span>
                                   <div class="text-lg font-bold text-blue-600 mt-1">{{ $coupon->value }}%</div>
                              @else
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-dollar-sign mr-1"></i>
                                        Cố định
                                   </span>
                                   <div class="text-lg font-bold text-green-600 mt-1">{{ number_format($coupon->value, 0, ',', '.') }}đ</div>
                              @endif
                         </div>
                         </td>
                         <td class="px-6 py-4">
                         <div class="text-xs space-y-1">
                              @if($coupon->min_order_amount)
                              <div class="flex items-center text-gray-600">
                                   <i class="fas fa-shopping-cart mr-1 w-4"></i>
                                   <span>Tối thiểu: {{ number_format($coupon->min_order_amount, 0, ',', '.') }}đ</span>
                              </div>
                              @endif
                              
                              @if($coupon->max_discount_amount && $coupon->type == 'percentage')
                              <div class="flex items-center text-gray-600">
                                   <i class="fas fa-arrow-down mr-1 w-4"></i>
                                   <span>Tối đa: {{ number_format($coupon->max_discount_amount, 0, ',', '.') }}đ</span>
                              </div>
                              @endif
                              
                              @if(!$coupon->min_order_amount && (!$coupon->max_discount_amount || $coupon->type != 'percentage'))
                              <div class="text-gray-400 italic">Không có điều kiện</div>
                              @endif
                         </div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="text-sm">
                              <div class="font-semibold text-gray-900">
                                   {{ $coupon->used_count }}
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
                                   <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                                   </div>
                              @endif
                              @if($coupon->usage_per_user)
                              <div class="text-xs text-gray-500 mt-1">
                                   <i class="fas fa-user mr-1"></i>{{ $coupon->usage_per_user }}/người
                              </div>
                              @endif
                         </div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm">
                         @if($coupon->start_date || $coupon->end_date)
                              <div class="space-y-1">
                                   @if($coupon->start_date)
                                   <div class="flex items-center text-gray-600">
                                        <i class="far fa-calendar-plus mr-1 w-4"></i>
                                        <span class="text-xs">{{ $coupon->start_date->format('d/m/Y') }}</span>
                                   </div>
                                   @endif
                                   
                                   @if($coupon->end_date)
                                   <div class="flex items-center {{ $coupon->end_date->isPast() ? 'text-red-600' : 'text-gray-600' }}">
                                        <i class="far fa-calendar-times mr-1 w-4"></i>
                                        <span class="text-xs">{{ $coupon->end_date->format('d/m/Y') }}</span>
                                   </div>
                                   @endif
                              </div>
                         @else
                              <span class="text-gray-400 italic text-xs">Không giới hạn</span>
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         @if($coupon->isValid())
                              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                   <i class="fas fa-check-circle mr-1"></i>Hợp lệ
                              </span>
                         @else
                              @if(!$coupon->is_active)
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-power-off mr-1"></i>Tắt
                                   </span>
                              @elseif($coupon->start_date && now()->lt($coupon->start_date))
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Chưa bắt đầu
                                   </span>
                              @elseif($coupon->end_date && now()->gt($coupon->end_date))
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-calendar-times mr-1"></i>Hết hạn
                                   </span>
                              @elseif($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit)
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-ban mr-1"></i>Hết lượt
                                   </span>
                              @endif
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                         <div class="flex items-center justify-end gap-2">
                              <a href="{{ route('admin.coupons.show', $coupon->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded transition"
                                   title="Xem chi tiết">
                                   <i class="fas fa-eye"></i>
                              </a>
                              
                              <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded transition"
                                   title="Chỉnh sửa">
                                   <i class="fas fa-edit"></i>
                              </a>
                              
                              <form action="{{ route('admin.coupons.toggle-status', $coupon->id) }}" 
                                   method="POST" 
                                   class="inline">
                                   @csrf
                                   <button type="submit" 
                                        class="p-2 rounded transition {{ $coupon->is_active ? 'text-green-600 hover:text-green-900 hover:bg-green-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                                        title="{{ $coupon->is_active ? 'Vô hiệu hóa' : 'Kích hoạt' }}">
                                        <i class="fas {{ $coupon->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                   </button>
                              </form>
                              
                              @if($coupon->orders()->count() == 0)
                              <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" 
                                   method="POST" 
                                   class="inline"
                                   onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" 
                                        class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded transition"
                                        title="Xóa">
                                        <i class="fas fa-trash"></i>
                                   </button>
                              </form>
                              @else
                              <button type="button" 
                                   class="text-gray-400 p-2 cursor-not-allowed"
                                   title="Không thể xóa (đã được sử dụng)"
                                   disabled>
                                   <i class="fas fa-trash"></i>
                              </button>
                              @endif
                         </div>
                         </td>
                    </tr>
                    @empty
                    <tr>
                         <td colspan="7" class="px-6 py-12 text-center">
                         <div class="flex flex-col items-center justify-center">
                              <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                   <i class="fas fa-ticket-alt text-4xl text-gray-400"></i>
                              </div>
                              <h3 class="text-lg font-semibold text-gray-900 mb-2">Chưa Có Mã Giảm Giá</h3>
                              <p class="text-gray-500 mb-4">Tạo mã giảm giá đầu tiên để khuyến mãi cho khách hàng</p>
                              <a href="{{ route('admin.coupons.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                   <i class="fas fa-plus mr-2"></i>
                                   Tạo Mã Giảm Giá
                              </a>
                         </div>
                         </td>
                    </tr>
                    @endforelse
               </tbody>
          </table>
     </div>
    
     <!-- Pagination -->
     @if($coupons->hasPages())
     <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
          <div class="flex items-center justify-between">
               <div class="flex-1 flex justify-between sm:hidden">
                    @if ($coupons->onFirstPage())
                         <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100">
                         Trước
                         </span>
                    @else
                         <a href="{{ $coupons->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                         Trước
                         </a>
                    @endif

                    @if ($coupons->hasMorePages())
                         <a href="{{ $coupons->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                         <span class="font-medium">{{ $coupons->firstItem() ?? 0 }}</span>
                         đến
                         <span class="font-medium">{{ $coupons->lastItem() ?? 0 }}</span>
                         trong tổng số
                         <span class="font-medium">{{ $coupons->total() }}</span>
                         mã giảm giá
                         </p>
                    </div>
                    <div>
                         {{ $coupons->links() }}
                    </div>
               </div>
          </div>
     </div>
     @endif
</div>
@endsection