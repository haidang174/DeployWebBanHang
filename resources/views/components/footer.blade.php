<footer class="bg-gray-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-xl font-bold mb-4">Fashion Shop</h3>
                <p class="text-gray-400">
                    Cửa hàng thời trang hàng đầu Việt Nam với những sản phẩm chất lượng cao.
                </p>
            </div>
            
            <!-- Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Liên Kết</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Trang Chủ</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">Sản Phẩm</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">Về Chúng Tôi</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Liên Hệ</a></li>
                </ul>
            </div>
            
            <!-- Customer Service -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Hỗ Trợ</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white">Chính Sách Đổi Trả</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Hướng Dẫn Mua Hàng</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Chính Sách Bảo Mật</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Điều Khoản Sử Dụng</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Liên Hệ</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><i class="fas fa-map-marker-alt mr-2"></i>180 Cao Lỗ, Q.8, TP.HCM</li>
                    <li><i class="fas fa-phone mr-2"></i>0123 456 789</li>
                    <li><i class="fas fa-envelope mr-2"></i>info@fashionshop.vn</li>
                </ul>
                
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-tiktok text-xl"></i></a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2024 Fashion Shop. All rights reserved.</p>
        </div>
    </div>
</footer>