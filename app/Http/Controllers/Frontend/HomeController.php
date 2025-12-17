<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        
        // Sản phẩm mới nhất
        $newProducts = Product::with(['category', 'mainImage', 'attributes'])
            ->latest()
            ->take(8)
            ->get();
        
        // Sản phẩm bán chạy (giả định dựa vào số lượng order)
        $bestSellers = Product::with(['category', 'mainImage', 'attributes'])
            ->withCount('orderDetails')
            ->orderBy('order_details_count', 'desc')
            ->take(8)
            ->get();
        
        return view('frontend.home', compact('categories', 'newProducts', 'bestSellers'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Xử lý gửi email hoặc lưu database
        // Mail::to('admin@example.com')->send(new ContactMail($request->all()));

        return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm.');
    }
}