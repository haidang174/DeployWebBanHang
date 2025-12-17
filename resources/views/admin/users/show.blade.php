@extends('layouts.admin')

@section('title', 'Chi Tiết Người Dùng - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div class="flex items-center gap-3">
               <a href="{{ route('admin.users.index') }}" 
                    class="text-gray-600 hover:text-gray-900 transition">
                    <i class="fas fa-arrow-left text-xl"></i>
               </a>
               <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-1">Chi tiết thông tin người dùng</p>
               </div>
          </div>
          
          <div class="flex gap-2">
               <a href="{{ route('admin.users.edit', $user->id) }}" 
                    class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition font-semibold">
                    <i class="fas fa-edit mr-2"></i>
                    Chỉnh Sửa
               </a>
               
               @if($user->orders()->count() == 0 && !$user->is_admin)
               <form action="{{ route('admin.users.destroy', $user->id) }}" 
                    method="POST" 
                    class="inline"
                    onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA NGƯỜI DÙNG NÀY?\n\nHành động này không thể hoàn tác!')">
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
                    <p class="text-sm text-gray-600 mb-1">Tổng Đơn Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $user->orders()->count() }}</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đã Hoàn Thành</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ $user->orders()->where('status', 'delivered')->count() }}
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
                    <p class="text-sm text-gray-600 mb-1">Đang Xử Lý</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ $user->orders()->whereIn('status', ['pending', 'confirmed', 'processing', 'shipping'])->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Chi Tiêu</p>
                    <h3 class="text-2xl font-bold text-gray-900">
                         {{ number_format($user->orders()->where('status', 'delivered')->sum('total_amount'), 0, ',', '.') }}đ
                    </h3>
               </div>
               <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-2xl text-purple-600"></i>
               </div>
          </div>
     </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
     <!-- Main Content -->
     <div class="lg:col-span-2 space-y-6">
          <!-- User Info -->
          <div class="bg-white rounded-lg shadow-md p-6">
               <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Thông Tin Người Dùng
               </h2>
               
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                         Họ và Tên
                         </label>
                         <div class="text-lg font-bold text-gray-900">{{ $user->name }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-hashtag text-purple-600 mr-2"></i>
                         ID
                         </label>
                         <div class="text-lg font-bold text-gray-900">#{{ $user->id }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-envelope text-green-600 mr-2"></i>
                         Email
                         </label>
                         <div class="text-gray-900">{{ $user->email }}</div>
                         @if($user->email_verified_at)
                         <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                              <i class="fas fa-check-circle mr-1"></i>Đã xác thực
                         </span>
                         @else
                         <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                              <i class="fas fa-clock mr-1"></i>Chưa xác thực
                         </span>
                         @endif
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-user-shield text-purple-600 mr-2"></i>
                         Vai Trò
                         </label>
                         <div>
                         @if($user->is_admin)
                              <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                   <i class="fas fa-user-shield mr-2"></i>Quản trị viên
                              </span>
                         @else
                              <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                   <i class="fas fa-user mr-2"></i>Khách hàng
                              </span>
                         @endif
                         </div>
                    </div>
                    
                    @if($user->google_id)
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fab fa-google text-red-600 mr-2"></i>
                         Đăng Nhập Google
                         </label>
                         <div>
                         <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                              <i class="fab fa-google mr-2"></i>Đã liên kết
                         </span>
                         </div>
                         <div class="text-xs text-gray-500 mt-1">ID: {{ $user->google_id }}</div>
                    </div>
                    @endif
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-calendar-plus text-green-600 mr-2"></i>
                         Ngày Tham Gia
                         </label>
                         <div class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</div>
                    </div>
                    
                    <div>
                         <label class="text-sm font-semibold text-gray-600 block mb-2">
                         <i class="fas fa-clock text-yellow-600 mr-2"></i>
                         Cập Nhật Lần Cuối
                         </label>
                         <div class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                         <div class="text-xs text-gray-500 mt-1">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
               </div>
          </div>
          
          <!-- Orders List -->
          @if($user->orders->count() > 0)
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
               <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                         <h2 class="text-xl font-bold text-gray-900 flex items-center">
                         <i class="fas fa-shopping-cart text-blue-600 mr-2"></i>
                         Đơn Hàng ({{ $user->orders()->count() }})
                         </h2>
                    </div>
               </div>
               
               <div class="divide-y divide-gray-200">
                    @foreach($user->orders as $order)
                    <div class="p-4 hover:bg-gray-50 transition">
                         <div class="flex items-center justify-between gap-4">
                         <div class="flex-1">
                              <div class="flex items-center gap-3 mb-2">
                                   <a href="{{ route('admin.orders.show', $order->id) }}" 
                                        class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $order->order_code }}
                                   </a>
                                   
                                   @if($order->status == 'delivered')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                             <i class="fas fa-check-double mr-1"></i>Đã giao
                                        </span>
                                   @elseif($order->status == 'cancelled')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                             <i class="fas fa-ban mr-1"></i>Đã hủy
                                        </span>
                                   @elseif($order->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                             <i class="fas fa-clock mr-1"></i>Chờ xác nhận
                                        </span>
                                   @elseif($order->status == 'shipping')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                             <i class="fas fa-shipping-fast mr-1"></i>Đang giao
                                        </span>
                                   @endif
                                   
                                   @if($order->payment_status == 'paid')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                             <i class="fas fa-check-circle mr-1"></i>Đã thanh toán
                                        </span>
                                   @endif
                              </div>
                              
                              <div class="flex items-center gap-4 text-sm text-gray-600">
                                   <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                   </span>
                                   <span>
                                        <i class="fas fa-box mr-1"></i>
                                        {{ $order->orderDetails->sum('quantity') }} sản phẩm
                                   </span>
                                   @if($order->payment_method == 'cod')
                                        <span class="text-green-600">
                                             <i class="fas fa-money-bill-wave mr-1"></i>COD
                                        </span>
                                   @elseif($order->payment_method == 'momo')
                                        <span class="text-pink-600">
                                             <i class="fab fa-cc-visa mr-1"></i>MoMo
                                        </span>
                                   @endif
                              </div>
                         </div>
                         
                         <div class="text-right">
                              <div class="text-lg font-bold text-blue-600">
                                   {{ number_format($order->total_amount, 0, ',', '.') }}đ
                              </div>
                              @if($order->discount_amount > 0)
                              <div class="text-xs text-green-600">
                                   Giảm: {{ number_format($order->discount_amount, 0, ',', '.') }}đ
                              </div>
                              @endif
                         </div>
                         </div>
                    </div>
                    @endforeach
               </div>
               
               @if($user->orders()->count() > 10)
               <div class="px-6 py-4 bg-gray-50 text-center">
                    <p class="text-sm text-gray-600">
                         Hiển thị 10 đơn hàng gần nhất. Tổng cộng: <strong>{{ $user->orders()->count() }}</strong> đơn hàng
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
                    <p class="text-gray-600">Người dùng này chưa đặt đơn hàng nào</p>
               </div>
          </div>
          @endif
     </div>
    
     <!-- Sidebar -->
     <div class="lg:col-span-1 space-y-6">
          <!-- User Card -->
          <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg shadow-md p-6 text-white">
               <h3 class="font-bold mb-4 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i>
                    Thông Tin
               </h3>
               
               <div class="bg-white/10 backdrop-blur rounded-lg p-4 mb-4">
                    <div class="text-center">
                         <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                              alt="{{ $user->name }}"
                              class="w-24 h-24 mx-auto mb-3 rounded-full border-4 border-white/20">
                         <div class="text-xl font-bold mb-1">{{ $user->name }}</div>
                         <div class="text-sm opacity-90">{{ $user->email }}</div>
                    </div>
               </div>
               
               <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                         <span class="opacity-90">Vai trò:</span>
                         <span class="font-semibold">{{ $user->is_admin ? 'Admin' : 'Khách hàng' }}</span>
                    </div>
                    <div class="flex justify-between">
                         <span class="opacity-90">Trạng thái:</span>
                         <span class="font-semibold">Hoạt động</span>
                    </div>
                    <div class="flex justify-between">
                         <span class="opacity-90">Tham gia:</span>
                         <span class="font-semibold">{{ $user->created_at->diffForHumans() }}</span>
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
                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                         class="block p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition text-sm font-semibold text-yellow-700">
                         <i class="fas fa-edit mr-2"></i>
                         Chỉnh Sửa Người Dùng
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                         class="block p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition text-sm font-semibold text-blue-700">
                         <i class="fas fa-users mr-2"></i>
                         Tất Cả Người Dùng
                    </a>
                    
                    @if($user->orders()->count() > 0)
                    <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" 
                         class="block p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition text-sm font-semibold text-purple-700">
                         <i class="fas fa-shopping-cart mr-2"></i>
                         Xem Đơn Hàng
                    </a>
                    @endif
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
                         <span class="font-bold text-lg">{{ $user->orders()->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Đơn hoàn thành:</span>
                         <span class="font-bold text-lg">{{ $user->orders()->where('status', 'delivered')->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                         <span class="text-sm opacity-90">Đơn đã hủy:</span>
                         <span class="font-bold text-lg">{{ $user->orders()->where('status', 'cancelled')->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                         <span class="text-sm opacity-90">Tổng chi tiêu:</span>
                         <span class="font-bold text-lg">{{ number_format($user->orders()->where('status', 'delivered')->sum('total_amount'), 0, ',', '.') }}đ</span>
                    </div>
               </div>
          </div>
          
          <!-- Delete Warning -->
          @if($user->orders()->count() == 0 && !$user->is_admin)
          <div class="bg-red-50 rounded-lg border-2 border-red-200 p-6">
               <h3 class="font-bold text-red-900 mb-3 flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                    Xóa Người Dùng
               </h3>
               <p class="text-sm text-red-700 mb-4">
                    Người dùng này chưa có đơn hàng và có thể xóa. Hành động này không thể hoàn tác.
               </p>
               <form action="{{ route('admin.users.destroy', $user->id) }}" 
                    method="POST" 
                    onsubmit="return confirm('⚠️ BẠN CÓ CHẮC CHẮN MUỐN XÓA NGƯỜI DÙNG NÀY?\n\nHành động này không thể hoàn tác!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                         class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                         <i class="fas fa-trash-alt mr-2"></i>
                         Xóa Người Dùng
                    </button>
               </form>
          </div>
          @elseif($user->is_admin)
          <div class="bg-purple-50 rounded-lg border-2 border-purple-200 p-6">
               <h3 class="font-bold text-purple-900 mb-3 flex items-center">
                    <i class="fas fa-shield-alt text-purple-600 mr-2"></i>
                    Tài Khoản Admin
               </h3>
               <p class="text-sm text-purple-700">
                    Đây là tài khoản quản trị viên. Không thể xóa tài khoản admin.
               </p>
          </div>
          @else
          <div class="bg-orange-50 rounded-lg border-2 border-orange-200 p-6">
               <h3 class="font-bold text-orange-900 mb-3 flex items-center">
                    <i class="fas fa-lock text-orange-600 mr-2"></i>
                    Không Thể Xóa
               </h3>
               <p class="text-sm text-orange-700">
                    Người dùng này có {{ $user->orders()->count() }} đơn hàng. Không thể xóa tài khoản có đơn hàng.
               </p>
          </div>
          @endif
     </div>
</div>
@endsection