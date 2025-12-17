<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalProducts = Product::count();
        $totalUsers = User::count();

        // Đơn hàng hôm nay
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Đơn hàng theo trạng thái
        $ordersByStatus = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Đơn hàng 7 ngày gần nhất
        $recentOrders = Order::with(['user'])
            ->latest()
            ->take(10)
            ->get();

        // Doanh thu 7 ngày gần nhất
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $last7Days[] = [
                'date' => $date->format('d/m'),
                'revenue' => Order::whereDate('created_at', $date)
                    ->where('payment_status', 'paid')
                    ->sum('total_amount'),
            ];
        }

        // Top sản phẩm bán chạy
        $topProducts = Product::withCount('orderDetails')
            ->with('mainImage')
            ->orderBy('order_details_count', 'desc')
            ->take(5)
            ->get();

        // Sản phẩm sắp hết hàng (tồn kho < 10)
        $lowStockProducts = Product::with(['attributes' => function($query) {
            $query->where('quantity', '<', 10);
        }])->whereHas('attributes', function($query) {
            $query->where('quantity', '<', 10);
        })->take(5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'todayOrders',
            'todayRevenue',
            'ordersByStatus',
            'recentOrders',
            'last7Days',
            'topProducts',
            'lowStockProducts'
        ));
    }
}