@extends('layouts.app')

@section('title', 'Đơn Hàng Của Tôi - Fashion Shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Đơn Hàng Của Tôi</h1>
    
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Order Header -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200">
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-lg">{{ $order->order_code }}</span>
                                
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                        'processing' => 'bg-purple-100 text-purple-800',
                                        'shipping' => 'bg-indigo-100 text-indigo-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    
                                    $statusLabels = [
                                        'pending' => 'Chờ xác nhận',
                                        'confirmed' => 'Đã xác nhận',
                                        'processing' => 'Đang xử lý',
                                        'shipping' => 'Đang giao',
                                        'delivered' => 'Đã giao',
                                        'cancelled' => 'Đã hủy',
                                    ];
                                @endphp
                                
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] }}">
                                    {{ $statusLabels[$order->status] }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('order.show', $order->id) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Xem Chi Tiết
                            </a>
                            
                            @if($order->canBeCancelled())
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                    @csrf
                                    <button type="submit" 
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                        Hủy Đơn
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($order->orderDetails->take(2) as $detail)
                                <div class="flex gap-4">
                                    <img src="{{ $detail->product_image }}" 
                                         alt="{{ $detail->product_name }}"
                                         class="w-20 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <div class="font-medium">{{ $detail->product_name }}</div>
                                        <div class="text-sm text-gray-500">
                                            @if($detail->size)Size: {{ $detail->size }}@endif
                                            @if($detail->color) | Màu: {{ $detail->color }}@endif
                                        </div>
                                        <div class="text-sm">{{ $detail->quantity }} x {{ number_format($detail->price, 0, ',', '.') }}đ</div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($order->orderDetails->count() > 2)
                                <div class="text-sm text-gray-500 text-center pt-2">
                                    Và {{ $order->orderDetails->count() - 2 }} sản phẩm khác...
                                </div>
                            @endif
                        </div>
                        
                        <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                            <div class="text-sm text-gray-600">
                                Phương thức: <span class="font-medium">{{ $order->payment_method == 'cod' ? 'COD' : 'Momo' }}</span>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Tổng tiền:</div>
                                <div class="text-2xl font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }}đ</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">Bạn chưa có đơn hàng nào</p>
            <a href="{{ route('products.index') }}" 
           class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Mua Sắm Ngay
        </a>
    </div>
     @endif
</div>
@endsection