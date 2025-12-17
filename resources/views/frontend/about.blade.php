@extends('layouts.app')

@section('title', 'Về Chúng Tôi - Fashion Shop')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h1 class="text-5xl font-bold mb-4">Về Fashion Shop</h1>
          <p class="text-xl">Câu chuyện của chúng tôi</p>
     </div>
</section>

<!-- Our Story -->
<section class="py-16">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
               <div>
                    <h2 class="text-3xl font-bold mb-6">Câu Chuyện Của Chúng Tôi</h2>
                    <div class="space-y-4 text-gray-700">
                         <p>
                         Fashion Shop được thành lập vào năm 2020 với sứ mệnh mang đến những sản phẩm thời trang 
                         chất lượng cao với giá cả phải chăng cho người tiêu dùng Việt Nam.
                         </p>
                         <p>
                         Chúng tôi tin rằng thời trang không chỉ là quần áo, mà là cách bạn thể hiện bản thân, 
                         là phong cách sống và là nghệ thuật. Vì vậy, mỗi sản phẩm tại Fashion Shop đều được 
                         chọn lọc kỹ lưỡng về chất liệu, thiết kế và xu hướng.
                         </p>
                         <p>
                         Sau 4 năm hoạt động, chúng tôi tự hào đã phục vụ hơn 100,000 khách hàng trên toàn quốc 
                         và nhận được hàng ngàn đánh giá 5 sao từ khách hàng hài lòng.
                         </p>
                    </div>
               </div>
               
               <div class="relative">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800" 
                         alt="Fashion Store" 
                         class="rounded-lg shadow-2xl">
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-lg shadow-xl">
                         <div class="text-4xl font-bold text-blue-600">4+</div>
                         <div class="text-gray-600">Năm Kinh Nghiệm</div>
                    </div>
               </div>
          </div>
     </div>
</section>

<!-- Mission & Vision -->
<section class="py-16 bg-gray-50">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
               <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                         <i class="fas fa-bullseye text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Sứ Mệnh</h3>
                    <p class="text-gray-700">
                         Mang đến trải nghiệm mua sắm thời trang tuyệt vời nhất cho khách hàng Việt Nam 
                         với sản phẩm chất lượng, giá cả hợp lý và dịch vụ chăm sóc khách hàng tận tâm.
                    </p>
               </div>
               
               <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                         <i class="fas fa-eye text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Tầm Nhìn</h3>
                    <p class="text-gray-700">
                         Trở thành thương hiệu thời trang hàng đầu Việt Nam, được khách hàng tin tưởng 
                         và lựa chọn bởi chất lượng sản phẩm và trải nghiệm mua sắm xuất sắc.
                    </p>
               </div>
          </div>
     </div>
</section>

<!-- Core Values -->
<section class="py-16">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-center mb-12">Giá Trị Cốt Lõi</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
               <div class="text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                         <i class="fas fa-heart text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Tận Tâm</h3>
                    <p class="text-gray-600">Luôn đặt khách hàng làm trung tâm trong mọi quyết định</p>
               </div>
               
               <div class="text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                         <i class="fas fa-check-circle text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Chất Lượng</h3>
                    <p class="text-gray-600">Cam kết chất lượng sản phẩm và dịch vụ</p>
               </div>
               
               <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                         <i class="fas fa-lightbulb text-3xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Sáng Tạo</h3>
                    <p class="text-gray-600">Không ngừng đổi mới và cải tiến</p>
               </div>
               
               <div class="text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                         <i class="fas fa-handshake text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Uy Tín</h3>
                    <p class="text-gray-600">Xây dựng niềm tin qua hành động</p>
               </div>
          </div>
     </div>
</section>

<!-- Statistics -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
               <div>
                    <div class="text-5xl font-bold mb-2">100K+</div>
                    <div class="text-lg">Khách Hàng</div>
               </div>
               
               <div>
                    <div class="text-5xl font-bold mb-2">10K+</div>
                    <div class="text-lg">Sản Phẩm</div>
               </div>
               
               <div>
                    <div class="text-5xl font-bold mb-2">50+</div>
                    <div class="text-lg">Thành Phố</div>
               </div>
               
               <div>
                    <div class="text-5xl font-bold mb-2">98%</div>
                    <div class="text-lg">Hài Lòng</div>
               </div>
          </div>
     </div>
</section>

<!-- Team Section -->
<section class="py-16">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-center mb-12">Đội Ngũ Của Chúng Tôi</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
               <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=Nguyen+Van+A&size=200&background=3B82F6&color=fff" 
                         alt="CEO" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold">Nguyễn Văn A</h3>
                    <p class="text-gray-600">CEO & Founder</p>
                    <div class="flex justify-center gap-4 mt-3">
                         <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook"></i></a>
                         <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                         <a href="#" class="text-blue-700 hover:text-blue-900"><i class="fab fa-linkedin"></i></a>
                    </div>
               </div>
               
               <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=Tran+Thi+B&size=200&background=EC4899&color=fff" 
                         alt="CMO" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold">Trần Thị B</h3>
                    <p class="text-gray-600">Marketing Director</p>
                    <div class="flex justify-center gap-4 mt-3">
                         <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook"></i></a>
                         <a href="#" class="text-pink-600 hover:text-pink-800"><i class="fab fa-instagram"></i></a>
                         <a href="#" class="text-blue-700 hover:text-blue-900"><i class="fab fa-linkedin"></i></a>
                    </div>
               </div>
               
               <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=Le+Van+C&size=200&background=10B981&color=fff" 
                         alt="COO" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold">Lê Văn C</h3>
                    <p class="text-gray-600">Operations Director</p>
                    <div class="flex justify-center gap-4 mt-3">
                         <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook"></i></a>
                         <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                         <a href="#" class="text-blue-700 hover:text-blue-900"><i class="fab fa-linkedin"></i></a>
                    </div>
               </div>
               
               <div class="text-center">
                    <img src="https://ui-avatars.com/api/?name=Pham+Thi+D&size=200&background=F59E0B&color=fff" 
                         alt="CTO" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 shadow-lg">
                    <h3 class="text-xl font-bold">Phạm Thị D</h3>
                    <p class="text-gray-600">Technology Director</p>
                    <div class="flex justify-center gap-4 mt-3">
                         <a href="#" class="text-blue-600 hover:text-blue-800"><i class="fab fa-facebook"></i></a>
                         <a href="#" class="text-gray-800 hover:text-gray-600"><i class="fab fa-github"></i></a>
                         <a href="#" class="text-blue-700 hover:text-blue-900"><i class="fab fa-linkedin"></i></a>
                    </div>
               </div>
          </div>
     </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gray-50">
     <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 class="text-3xl font-bold mb-4">Sẵn Sàng Mua Sắm?</h2>
          <p class="text-gray-600 text-lg mb-8">
               Khám phá bộ sưu tập thời trang đa dạng và trendy của chúng tôi
          </p>
          <div class="flex justify-center gap-4">
               <a href="{{ route('products.index') }}" 
                    class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Xem Sản Phẩm
               </a>
               <a href="{{ route('contact') }}" 
                    class="bg-white text-blue-600 border-2 border-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Liên Hệ
               </a>
          </div>
     </div>
</section>
@endsection