<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Không cần constructor middleware vì đã dùng middleware trong routes
     */
    
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderDetails'])
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['orderDetails.productAttribute.product', 'coupon', 'paymentTransactions'])
            ->findOrFail($id);

        return view('frontend.orders.show', compact('order'));
    }

    public function success($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['orderDetails'])
            ->findOrFail($id);

        return view('frontend.orders.success', compact('order'));
    }

    public function failed($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['orderDetails'])
            ->findOrFail($id);

        return view('frontend.orders.failed', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Không thể hủy đơn hàng này!');
        }

        // Hoàn lại tồn kho
        foreach ($order->orderDetails as $detail) {
            $detail->productAttribute->increaseStock($detail->quantity);
        }

        $order->updateStatus('cancelled');

        return back()->with('success', 'Đã hủy đơn hàng thành công!');
    }

    /**
     * Hiển thị form tracking (không cần auth - dùng cho khách)
     */
    public function showTrackForm()
    {
        return view('frontend.orders.track-form');
    }

    /**
     * Xử lý tracking order (không cần auth - dùng cho khách)
     */
    public function trackOrder(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_code', $request->order_code)
            ->where('customer_email', $request->email)
            ->with(['orderDetails.productAttribute.product'])
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng hoặc email không khớp!')->withInput();
        }

        return view('frontend.orders.track-result', compact('order'));
    }
}