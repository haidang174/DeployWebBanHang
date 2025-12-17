@extends('layouts.admin')

@section('title', 'Quản Lý Người Dùng - Admin')

@section('content')
<div class="mb-6">
     <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
          <div>
               <h1 class="text-3xl font-bold text-gray-900">Quản Lý Người Dùng</h1>
               <p class="text-gray-600 mt-1">Quản lý tài khoản người dùng trong hệ thống</p>
          </div>
          
          <div class="flex gap-2">
               <a href="{{ route('admin.users.create') }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-plus mr-2"></i>
                    Thêm Người Dùng
               </a>
          </div>
     </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Tổng Người Dùng</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</h3>
               </div>
               <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Quản Trị Viên</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\User::where('is_admin', true)->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-2xl text-purple-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Khách Hàng</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\User::where('is_admin', false)->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-2xl text-green-600"></i>
               </div>
          </div>
     </div>
    
     <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
          <div class="flex items-center justify-between">
               <div>
                    <p class="text-sm text-gray-600 mb-1">Đã Xác Thực Email</p>
                    <h3 class="text-3xl font-bold text-gray-900">
                         {{ \App\Models\User::whereNotNull('email_verified_at')->count() }}
                    </h3>
               </div>
               <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-yellow-600"></i>
               </div>
          </div>
     </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
     <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
               <!-- Search -->
               <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                         <i class="fas fa-search text-blue-600 mr-1"></i>
                         Tìm Kiếm
                    </label>
                    <input type="text" 
                         name="search" 
                         value="{{ request('search') }}"
                         placeholder="Tên, email..."
                         class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
               </div>
               
               <!-- Actions -->
               <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                         <i class="fas fa-search mr-2"></i>
                         Tìm Kiếm
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                         class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition font-semibold">
                         <i class="fas fa-redo"></i>
                    </a>
               </div>
          </div>
     </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
     <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
               <thead class="bg-gray-50">
                    <tr>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Người Dùng
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Email
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Vai Trò
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Đơn Hàng
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Trạng Thái
                         </th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Ngày Tham Gia
                         </th>
                         <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                         Thao Tác
                         </th>
                    </tr>
               </thead>
               <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="flex items-center">
                              <div class="flex-shrink-0 w-10 h-10">
                                   <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                                        alt="{{ $user->name }}"
                                        class="w-10 h-10 rounded-full">
                              </div>
                              <div class="ml-3">
                                   <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                   <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                              </div>
                         </div>
                         </td>
                         <td class="px-6 py-4">
                         <div class="text-sm text-gray-900">{{ $user->email }}</div>
                         @if($user->email_verified_at)
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                   <i class="fas fa-check-circle mr-1"></i>Đã xác thực
                              </span>
                         @else
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                   <i class="fas fa-clock mr-1"></i>Chưa xác thực
                              </span>
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         @if($user->is_admin)
                              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                   <i class="fas fa-user-shield mr-1"></i>Admin
                              </span>
                         @else
                              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                   <i class="fas fa-user mr-1"></i>Khách hàng
                              </span>
                         @endif
                         
                         @if($user->google_id)
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                   <i class="fab fa-google mr-1"></i>Google
                              </span>
                         @endif
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         <div class="flex items-center">
                              <i class="fas fa-shopping-cart text-blue-600 mr-2"></i>
                              <span class="font-semibold text-gray-900">{{ $user->orders_count }}</span>
                              <span class="text-sm text-gray-500 ml-1">đơn</span>
                         </div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                              <i class="fas fa-circle text-green-400 mr-1 text-xs"></i>Hoạt động
                         </span>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                         <div>{{ $user->created_at->format('d/m/Y') }}</div>
                         <div class="text-xs text-gray-400">{{ $user->created_at->format('H:i') }}</div>
                         </td>
                         <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                         <div class="flex items-center justify-end gap-2">
                              <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded transition"
                                   title="Xem chi tiết">
                                   <i class="fas fa-eye"></i>
                              </a>
                              
                              <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 p-2 hover:bg-yellow-50 rounded transition"
                                   title="Chỉnh sửa">
                                   <i class="fas fa-edit"></i>
                              </a>
                              
                              @if($user->orders()->count() == 0 && !$user->is_admin)
                              <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                   method="POST" 
                                   class="inline"
                                   onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
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
                                   title="{{ $user->is_admin ? 'Không thể xóa admin' : 'Không thể xóa (có đơn hàng)' }}"
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
                                   <i class="fas fa-users text-4xl text-gray-400"></i>
                              </div>
                              <h3 class="text-lg font-semibold text-gray-900 mb-2">Không Tìm Thấy Người Dùng</h3>
                              <p class="text-gray-500">
                                   @if(request()->has('search'))
                                        Không có người dùng nào phù hợp với tìm kiếm của bạn.
                                   @else
                                        Chưa có người dùng nào trong hệ thống.
                                   @endif
                              </p>
                              @if(request()->has('search'))
                                   <a href="{{ route('admin.users.index') }}" 
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-redo mr-2"></i>
                                        Xóa Tìm Kiếm
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
     @if($users->hasPages())
     <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
          <div class="flex items-center justify-between">
               <div class="flex-1 flex justify-between sm:hidden">
                    @if ($users->onFirstPage())
                         <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100">
                         Trước
                         </span>
                    @else
                         <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                         Trước
                         </a>
                    @endif

                    @if ($users->hasMorePages())
                         <a href="{{ $users->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
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
                         <span class="font-medium">{{ $users->firstItem() ?? 0 }}</span>
                         đến
                         <span class="font-medium">{{ $users->lastItem() ?? 0 }}</span>
                         trong tổng số
                         <span class="font-medium">{{ $users->total() }}</span>
                         người dùng
                         </p>
                    </div>
                    <div>
                         {{ $users->links() }}
                    </div>
               </div>
          </div>
     </div>
     @endif
</div>
@endsection