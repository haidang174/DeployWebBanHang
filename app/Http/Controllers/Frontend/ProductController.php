<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra xem có sắp xếp theo giá không
        $sort = $request->get('sort', 'latest');
        $isPriceSort = in_array($sort, ['price_asc', 'price_desc']);

        // Nếu sắp xếp theo giá, sử dụng query đặc biệt
        if ($isPriceSort) {
            return $this->indexWithPriceSort($request);
        }

        // Query thông thường cho các trường hợp khác
        $query = Product::with(['category', 'mainImage', 'attributes']);

        // Lọc theo category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo giá
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('attributes', function ($q) use ($request) {
                if ($request->filled('min_price')) {
                    $q->where('price', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('price', '<=', $request->max_price);
                }
            });
        }

        // Sắp xếp
        switch ($sort) {
            case 'name':
                $query->orderBy('product_name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->appends($request->except('page'));
        $categories = Category::withCount('products')->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Xử lý riêng cho sắp xếp theo giá
     */
    private function indexWithPriceSort(Request $request)
    {
        $direction = $request->get('sort') === 'price_asc' ? 'asc' : 'desc';

        // Tạo query cơ bản
        $query = Product::query()
            ->select('products.*')
            ->selectSub(
                'SELECT MIN(price) FROM product_attributes WHERE product_attributes.product_id = products.id',
                'min_price'
            );

        // Lọc theo category
        if ($request->filled('category')) {
            $query->where('products.category_id', $request->category);
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $query->where('products.product_name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo giá
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereExists(function ($q) use ($request) {
                $q->select(DB::raw(1))
                    ->from('product_attributes')
                    ->whereColumn('product_attributes.product_id', 'products.id');
                
                if ($request->filled('min_price')) {
                    $q->where('product_attributes.price', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('product_attributes.price', '<=', $request->max_price);
                }
            });
        }

        // Sắp xếp theo giá
        $query->orderBy('min_price', $direction);

        // Lấy kết quả và load relationships
        $products = $query->paginate(12)->appends($request->except('page'));
        
        // Load relationships sau khi paginate
        $products->load(['category', 'mainImage', 'attributes']);

        $categories = Category::withCount('products')->get();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images', 'attributes'])
            ->findOrFail($id);

        // Sản phẩm liên quan
        $relatedProducts = Product::with(['mainImage', 'attributes'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q');
        
        $products = Product::with(['category', 'mainImage', 'attributes'])
            ->where('product_name', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->paginate(12);

        return view('frontend.products.search', compact('products', 'keyword'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        
        $products = Product::with(['mainImage', 'attributes'])
            ->where('category_id', $id)
            ->paginate(12);

        $categories = Category::withCount('products')->get();

        return view('frontend.products.category', compact('category', 'products', 'categories'));
    }
}