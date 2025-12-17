<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Thêm mã giảm giá thành công!');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['orders' => function($query) {
            $query->latest()->take(10);
        }]);
        
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_per_user' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy(Coupon $coupon)
    {
        // Kiểm tra đã được sử dụng chưa
        if ($coupon->orders()->count() > 0) {
            return back()->with('error', 'Không thể xóa mã giảm giá đã được sử dụng!');
        }

        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Xóa mã giảm giá thành công!');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        $status = $coupon->is_active ? 'kích hoạt' : 'vô hiệu hóa';

        return back()->with('success', "Đã {$status} mã giảm giá!");
    }
}