<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'mainImage']);

        // Tìm kiếm
        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(20);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'product_name' => 'required|string|max:191',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'attributes' => 'required|array|min:1',
            'attributes.*.price' => 'required|numeric|min:0',
            'attributes.*.quantity' => 'required|integer|min:0',
            'attributes.*.size' => 'nullable|string|max:50',
            'attributes.*.color' => 'nullable|string|max:50',
        ]);

        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            // Tạo sản phẩm
            $product = Product::create([
                'product_name' => $validated['product_name'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'] ?? null,
                'base_price' => $validated['base_price'],
            ]);

            // Xử lý upload ảnh
            if ($request->hasFile('images')) {
                $mainImageIndex = $request->input('main_image_index', 0);
                
                foreach ($request->file('images') as $index => $image) {
                    // Lưu file vào storage/app/public/products
                    $path = $image->store('products', 'public');
                    
                    // Lưu vào database
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                        'is_main' => ($index == $mainImageIndex) ? 1 : 0,
                    ]);
                }
            }

            // Lưu các phân loại (attributes/variants)
            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attribute) {
                    // Chỉ lưu nếu có đủ giá và số lượng
                    if (isset($attribute['price']) && isset($attribute['quantity'])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'size' => !empty($attribute['size']) ? $attribute['size'] : null,
                            'color' => !empty($attribute['color']) ? $attribute['color'] : null,
                            'price' => $attribute['price'],
                            'quantity' => $attribute['quantity'],
                        ]);
                    }
                }
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được thêm thành công!');

        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images', 'attributes']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'attributes']);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:191',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'attributes' => 'required|array|min:1',
            'attributes.*.id' => 'nullable|exists:product_attributes,id',
            'attributes.*.price' => 'required|numeric|min:0',
            'attributes.*.quantity' => 'required|integer|min:0',
            'attributes.*.size' => 'nullable|string|max:50',
            'attributes.*.color' => 'nullable|string|max:50',
            'attributes.*.deleted' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            // Update basic info
            $product->update([
                'product_name' => $validated['product_name'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'] ?? null,
                'base_price' => $validated['base_price'],
            ]);

            // Handle new images
            if ($request->hasFile('images')) {
                $currentImageCount = $product->images()->count();
                $newImageCount = count($request->file('images'));
                
                if ($currentImageCount + $newImageCount > 5) {
                    return back()->withErrors(['images' => 'Tổng số ảnh không được vượt quá 5!']);
                }
                
                $newMainImageIndex = $request->input('new_main_image_index');
                $isFirstImage = $currentImageCount == 0;
                
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    
                    // Set main image nếu được chỉ định hoặc là ảnh đầu tiên
                    $isMain = false;
                    if ($newMainImageIndex !== null && $index == $newMainImageIndex) {
                        $isMain = true;
                        // Bỏ main của các ảnh khác
                        ProductImage::where('product_id', $product->id)->update(['is_main' => 0]);
                    } elseif ($isFirstImage && $index == 0) {
                        $isMain = true;
                    }
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $path,
                        'is_main' => $isMain,
                    ]);
                }
            }

            // Handle attributes
            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attrData) {
                    // Check if marked for deletion
                    if (isset($attrData['deleted']) && $attrData['deleted'] == '1') {
                        // Only delete if it has an ID (existing record)
                        if (!empty($attrData['id'])) {
                            ProductAttribute::where('id', $attrData['id'])
                                ->where('product_id', $product->id)
                                ->delete();
                        }
                        continue;
                    }

                    // Update existing or create new
                    if (!empty($attrData['id'])) {
                        // Update existing attribute
                        ProductAttribute::where('id', $attrData['id'])
                            ->where('product_id', $product->id)
                            ->update([
                                'size' => $attrData['size'] ?? null,
                                'color' => $attrData['color'] ?? null,
                                'price' => $attrData['price'],
                                'quantity' => $attrData['quantity'],
                            ]);
                    } else {
                        // Create new attribute
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'size' => $attrData['size'] ?? null,
                            'color' => $attrData['color'] ?? null,
                            'price' => $attrData['price'],
                            'quantity' => $attrData['quantity'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        
        try {
            // Xóa images từ storage
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_url)) {
                    Storage::disk('public')->delete($image->image_url);
                }
            }

            // Xóa product (cascade sẽ xóa images, attributes)
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Xóa sản phẩm thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xóa image riêng lẻ (AJAX)
     */
    public function deleteImage($imageId)
    {
        try {
            $image = ProductImage::findOrFail($imageId);
            
            // Check if this is the main image
            if ($image->is_main) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa ảnh chính! Vui lòng đặt ảnh khác làm ảnh chính trước.'
                ], 400);
            }
            
            // Delete file from storage
            if (Storage::disk('public')->exists($image->image_url)) {
                Storage::disk('public')->delete($image->image_url);
            }
            
            // Delete from database
            $image->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa ảnh thành công!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Set main image (AJAX)
     */
    public function setMainImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            $productId = $image->product_id;
            
            // Remove main flag from all images of this product
            ProductImage::where('product_id', $productId)->update(['is_main' => 0]);
            
            // Set this image as main
            $image->update(['is_main' => 1]);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã đặt làm ảnh chính!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}