<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user']);

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo payment_status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', '%' . $search . '%')
                ->orWhere('customer_name', 'like', '%' . $search . '%')
                ->orWhere('customer_email', 'like', '%' . $search . '%')
                ->orWhere('customer_phone', 'like', '%' . $search . '%');
            });
        }

        // Lọc theo ngày
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'coupon', 'orderDetails.productAttribute.product', 'paymentTransactions']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipping,delivered,cancelled,refunded',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Nếu hủy đơn, hoàn lại tồn kho
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->orderDetails as $detail) {
                $detail->productAttribute->increaseStock($detail->quantity);
            }
        }

        // Nếu từ cancelled sang status khác, trừ lại tồn kho
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($order->orderDetails as $detail) {
                if (!$detail->productAttribute->decreaseStock($detail->quantity)) {
                    return back()->with('error', 'Không đủ tồn kho để khôi phục đơn hàng!');
                }
            }
        }

        $order->updateStatus($newStatus);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order->updatePaymentStatus($request->payment_status);

        return back()->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

    public function destroy(Order $order)
    {
        // Chỉ cho phép xóa đơn hàng đã hủy
        if ($order->status !== 'cancelled') {
            return back()->with('error', 'Chỉ có thể xóa đơn hàng đã hủy!');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Xóa đơn hàng thành công!');
    }

    public function print(Order $order)
    {
        $order->load(['orderDetails.productAttribute.product', 'coupon']);
        return view('admin.orders.print', compact('order'));
    }

    public function export(Request $request)
    {
        // TODO: Export orders to Excel/CSV
        return back()->with('info', 'Tính năng đang được phát triển!');
    }
}