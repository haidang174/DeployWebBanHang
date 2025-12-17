@extends('layouts.app')

@section('title', 'Giỏ Hàng - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Trang chủ</a></li>
            <li><i class="fas fa-chevron-right text-gray-400 text-xs"></i></li>
            <li class="text-gray-600">Giỏ hàng</li>
        </ol>
    </nav>
    
    <h1 class="text-3xl font-bold mb-8">Giỏ Hàng Của Bạn</h1>
    
    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @foreach($cartItems as $item)
                        <div class="flex flex-col sm:flex-row gap-4 p-6 border-b border-gray-200 last:border-b-0" 
                             x-data="{ quantity: {{ $item->quantity }}, updating: false }">
                            
                            <!-- Product Image -->
                            <a href="{{ route('products.show', $item->product->id) }}" class="flex-shrink-0">
                                <img src="{{ $item->product->main_image_url }}" 
                                     alt="{{ $item->product->product_name }}"
                                     class="w-32 h-32 object-cover rounded-lg">
                            </a>
                            
                            <!-- Product Info -->
                            <div class="flex-1">
                                <a href="{{ route('products.show', $item->product->id) }}" 
                                   class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                                    {{ $item->product->product_name }}
                                </a>
                                
                                <div class="text-sm text-gray-500 mt-2 space-y-1">
                                    @if($item->productAttribute->size)
                                        <div><span class="font-medium">Size:</span> {{ $item->productAttribute->size }}</div>
                                    @endif
                                    @if($item->productAttribute->color)
                                        <div><span class="font-medium">Màu:</span> {{ $item->productAttribute->color }}</div>
                                    @endif
                                    <div><span class="font-medium">Đơn giá:</span> {{ number_format($item->price, 0, ',', '.') }}đ</div>
                                </div>
                                
                                <!-- Quantity & Actions -->
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                            <button type="button" 
                                                    @click="quantity = Math.max(1, quantity - 1); updateCart({{ $item->id }}, quantity)"
                                                    class="px-3 py-1 hover:bg-gray-100">
                                                <i class="fas fa-minus text-sm"></i>
                                            </button>
                                            <input type="number" x-model="quantity" 
                                                   @change="updateCart({{ $item->id }}, quantity)"
                                                   min="1" max="{{ $item->productAttribute->quantity }}"
                                                   class="w-16 text-center border-x border-gray-300 py-1">
                                            <button type="button" 
                                                    @click="quantity = Math.min({{ $item->productAttribute->quantity }}, quantity + 1); updateCart({{ $item->id }}, quantity)"
                                                    class="px-3 py-1 hover:bg-gray-100">
                                                <i class="fas fa-plus text-sm"></i>
                                            </button>
                                        </div>
                                        
                                        <span class="text-xs text-gray-500">Còn {{ $item->productAttribute->quantity }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-4">
                                        <div class="text-lg font-bold text-blue-600" id="item-total-{{ $item->id }}">
                                            {{ number_format($item->total, 0, ',', '.') }}đ
                                        </div>
                                        
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" 
                                              onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Clear Cart -->
                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Tiếp tục mua sắm
                    </a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST" 
                          onsubmit="return confirm('Xóa tất cả sản phẩm trong giỏ hàng?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Xóa tất cả
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h2 class="text-xl font-bold mb-4">Tóm Tắt Đơn Hàng</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính ({{ $cart->total_items }} sản phẩm):</span>
                            <span class="font-semibold" id="cart-subtotal">{{ number_format($cart->subtotal, 0, ',', '.') }}đ</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí vận chuyển:</span>
                            <span class="font-semibold">30,000đ</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="text-lg font-bold">Tổng cộng:</span>
                            <span class="text-2xl font-bold text-blue-600" id="cart-total">
                                {{ number_format($cart->subtotal + 30000, 0, ',', '.') }}đ
                            </span>
                        </div>
                    </div>
                    
                    @auth
                        <a href="{{ route('checkout.index') }}" 
                           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Tiến Hành Thanh Toán
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Đăng Nhập Để Thanh Toán
                        </a>
                    @endauth
                    
                    <div class="mt-4 p-4 bg-green-50 rounded-lg">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-shipping-fast text-green-600 mt-1"></i>
                            <div class="text-sm text-gray-700">
                                <span class="font-semibold">Miễn phí vận chuyển</span> cho đơn hàng từ 500,000đ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">Giỏ hàng của bạn đang trống</p>
            <a href="{{ route('products.index') }}" 
               class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                Mua Sắm Ngay
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateCart(itemId, quantity) {
    fetch(`/cart/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`item-total-${itemId}`).textContent = data.item_total + 'đ';
            document.getElementById('cart-subtotal').textContent = data.cart_subtotal + 'đ';
            
            const subtotalNumber = parseInt(data.cart_subtotal.replace(/\./g, ''));
            const total = subtotalNumber + 30000;
            document.getElementById('cart-total').textContent = total.toLocaleString('vi-VN') + 'đ';
        } else {
            alert(data.message);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra!');
    });
}
</script>
@endpush
@endsection