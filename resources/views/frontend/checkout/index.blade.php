@extends('layouts.app')

@section('title', 'Thanh Toán - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
            <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
            <li><a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800">Giỏ hàng</a></li>
            <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
            <li class="text-gray-600">Thanh toán</li>
        </ol>
    </nav>
    
    <h1 class="text-3xl font-bold mb-8">Thanh Toán</h1>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Thông Tin Giao Hàng</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Họ và Tên *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('customer_name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', $user->email) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('customer_email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Số Điện Thoại *</label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('customer_phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Địa Chỉ *</label>
                            <textarea name="customer_address" rows="3" required
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ghi Chú (Tùy chọn)</label>
                            <textarea name="notes" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Phương Thức Thanh Toán</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="payment_method" value="cod" checked class="mr-3">
                            <div class="flex-1">
                                <div class="font-semibold">Thanh toán khi nhận hàng (COD)</div>
                                <div class="text-sm text-gray-500">Thanh toán bằng tiền mặt khi nhận hàng</div>
                            </div>
                            <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-600 transition">
                            <input type="radio" name="payment_method" value="momo" class="mr-3">
                            <div class="flex-1">
                                <div class="font-semibold">Thanh toán qua Momo</div>
                                <div class="text-sm text-gray-500">Thanh toán an toàn qua ví điện tử Momo</div>
                            </div>
                            <i class="fas fa-wallet text-2xl text-pink-600"></i>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h2 class="text-xl font-bold mb-4">Đơn Hàng</h2>
                    
                    <!-- Products -->
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex gap-3">
                                <img src="{{ $item->product->main_image_url }}" 
                                     alt="{{ $item->product->product_name }}"
                                     class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <div class="text-sm font-medium line-clamp-1">{{ $item->product->product_name }}</div>
                                    <div class="text-xs text-gray-500">
                                        @if($item->productAttribute->size)Size: {{ $item->productAttribute->size }}@endif
                                        @if($item->productAttribute->color) | Màu: {{ $item->productAttribute->color }}@endif
                                    </div>
                                    <div class="text-sm">{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}đ</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Coupon -->
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Mã giảm giá" 
                                   id="coupon-code"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <button type="button" onclick="applyCoupon()" 
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                                Áp dụng
                            </button>
                        </div>
                        
                        @if(session('coupon'))
                            <div class="mt-2 p-2 bg-green-50 rounded flex justify-between items-center">
                                <span class="text-sm text-green-700">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ session('coupon')['code'] }}
                                </span>
                                <form action="{{ route('checkout.remove-coupon') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 text-xs hover:text-red-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tạm tính:</span>
                            <span class="font-semibold">{{ number_format($cart->subtotal, 0, ',', '.') }}đ</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Phí vận chuyển:</span>
                            <span class="font-semibold">30,000đ</span>
                        </div>
                        
                        @if(session('coupon'))
                            <div class="flex justify-between text-sm text-green-600">
                                <span>Giảm giá:</span>
                                <span class="font-semibold">-{{ number_format(session('coupon')['discount'], 0, ',', '.') }}đ</span>
                            </div>
                        @endif
                        
                        <div class="border-t border-gray-200 pt-2 flex justify-between">
                            <span class="text-lg font-bold">Tổng cộng:</span>
                            @php
                                $total = $cart->subtotal + 30000 - (session('coupon')['discount'] ?? 0);
                            @endphp
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Đặt Hàng
                    </button>
                    
                    <div class="mt-4 text-xs text-gray-500 text-center">
                        Bằng việc đặt hàng, bạn đồng ý với 
                        <a href="#" class="text-blue-600 hover:underline">Điều khoản sử dụng</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function applyCoupon() {
    const code = document.getElementById('coupon-code').value;
    
    if (!code) {
        alert('Vui lòng nhập mã giảm giá!');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("checkout.apply-coupon") }}';
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
    
    const codeInput = document.createElement('input');
    codeInput.type = 'hidden';
    codeInput.name = 'coupon_code';
    codeInput.value = code;
    
    form.appendChild(csrfInput);
    form.appendChild(codeInput);
    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush
@endsection