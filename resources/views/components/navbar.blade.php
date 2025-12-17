<nav class="bg-white shadow-lg sticky top-0 z-40" x-data="{ mobileMenuOpen: false, cartCount: {{ auth()->check() ? auth()->user()->carts()->first()?->total_items ?? 0 : 0 }} }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-tshirt text-blue-600"></i>
                    Fashion Shop
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">
                    Trang Chủ
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('products.*') ? 'text-blue-600 font-semibold' : '' }}">
                    Sản Phẩm
                </a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('about') ? 'text-blue-600 font-semibold' : '' }}">
                    Về Chúng Tôi
                </a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('contact') ? 'text-blue-600 font-semibold' : '' }}">
                    Liên Hệ
                </a>
            </div>
            
            <!-- Right Menu -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <form action="{{ route('products.search') }}" method="GET" class="hidden md:block">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Tìm kiếm... " autocomplete="off"
                               class="w-64 px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-blue-600">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span x-show="cartCount > 0" 
                          x-text="cartCount"
                          class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    </span>
                </a>
                
                <!-- User Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                            <i class="fas fa-user-circle text-xl"></i>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('order.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-box mr-2"></i>
                                Đơn Hàng Của Tôi
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Đăng Xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-sign-in-alt mr-1"></i>
                        <span class="hidden md:inline">Đăng Nhập</span>
                    </a>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition
         class="md:hidden bg-white border-t border-gray-200">
        <div class="px-4 py-2 space-y-2">
            <!-- Mobile Search -->
            <form action="{{ route('products.search') }}" method="GET" class="mb-4">
                <input type="text" name="q" placeholder="Tìm kiếm..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </form>
            
            <a href="{{ route('home') }}" class="block py-2 text-gray-700">Trang Chủ</a>
            <a href="{{ route('products.index') }}" class="block py-2 text-gray-700">Sản Phẩm</a>
            <a href="{{ route('about') }}" class="block py-2 text-gray-700">Về Chúng Tôi</a>
            <a href="{{ route('contact') }}" class="block py-2 text-gray-700">Liên Hệ</a>
        </div>
    </div>
</nav>