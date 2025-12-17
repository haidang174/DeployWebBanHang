<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-between h-16 px-6 bg-gray-800">
                <h1 class="text-xl font-bold">Admin Panel</h1>
                <button @click="sidebarOpen = false" class="lg:hidden">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-list mr-3"></i>
                    Danh Mục
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-box mr-3"></i>
                    Sản Phẩm
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Đơn Hàng
                </a>
                
                <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.coupons.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-ticket-alt mr-3"></i>
                    Mã Giảm Giá
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-users mr-3"></i>
                    Người Dùng
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Xem Website
                    </a>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" 
                                 alt="Avatar" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Đăng Xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Alert Messages -->
            @include('components.alert')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>