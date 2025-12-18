<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
             'images' => 'nullable|array|max:' . self::MAX_IMAGES,
            'attributes' => 'required|array|min:1',
            'attributes.*.price' => 'required|numeric|min:0',
            'attributes.*.quantity' => 'required|integer|min:0',
            'attributes.*.size' => 'nullable|string|max:50',
            'attributes.*.color' => 'nullable|string|max:50',
        ]);

        $uploadedPublicIds = []; // Track uploaded images for rollback

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

            // Xử lý upload ảnh lên Cloudinary
            if ($request->hasFile('images')) {
                 $images = $request->file('images');
                $mainImageIndex = $request->input('main_image_index', 0);
                
                foreach ($images as $index => $image) {
                    try {
                        // Upload lên Cloudinary
                        $uploadedFile = Cloudinary::upload($image->getRealPath(), [
                            'folder' => 'products',
                            'transformation' => [
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]);
                        
                        $publicId = $uploadedFile->getPublicId();
                        $uploadedPublicIds[] = $publicId; // Track for rollback
                        
                        // Lưu vào database
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_url' => $publicId,
                            'is_main' => ($index == $mainImageIndex) ? 1 : 0,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to upload image: ' . $e->getMessage());
                        throw new \Exception('Không thể upload ảnh: ' . $e->getMessage());
                    }
                }
            }

            // Lưu các phân loại (attributes/variants)
            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attribute) {
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
            
            foreach ($uploadedPublicIds as $publicId) {
                try {
                    Cloudinary::destroy($publicId);
                } catch (\Exception $deleteError) {
                    Log::warning('Failed to rollback image deletion: ' . $deleteError->getMessage());
                }
            }

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

        $uploadedPublicIds = [];

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
                $newImages = $request->file('images');
                $newImageCount = count($newImages);
                
                // Check total image limit
                if ($currentImageCount + $newImageCount > self::MAX_IMAGES) {
                    throw new \Exception('Tổng số ảnh không được vượt quá ' . self::MAX_IMAGES . '!');
                }
                
                $newMainImageIndex = $request->input('new_main_image_index');
                
                // Validate new_main_image_index
                if ($newMainImageIndex !== null && ($newMainImageIndex < 0 || $newMainImageIndex >= $newImageCount)) {
                    $newMainImageIndex = null;
                }
                
                foreach ($request->file('images') as $index => $image) {
                    try {
                        // Upload lên Cloudinary
                        $uploadedFile = Cloudinary::upload($image->getRealPath(), [
                            'folder' => 'products',
                            'transformation' => [
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]);
                        
                        $publicId = $uploadedFile->getPublicId();
                        $uploadedPublicIds[] = $publicId; // Track for rollback
                        
                        // Set main image nếu được chỉ định
                        $isMain = false;
                        if ($newMainImageIndex !== null && $index == $newMainImageIndex) {
                            $isMain = true;
                            // Bỏ main của các ảnh khác
                            ProductImage::where('product_id', $product->id)->update(['is_main' => 0]);
                        }
                        
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_url' => $publicId,
                            'is_main' => $isMain,
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to upload image: ' . $e->getMessage());
                        throw new \Exception('Không thể upload ảnh: ' . $e->getMessage());
                    }
                }
            }

            // Handle attributes
            if (!empty($validated['attributes'])) {
                $hasValidAttribute = false;

                foreach ($validated['attributes'] as $attrData) {
                    // Check if marked for deletion
                    if (isset($attrData['deleted']) && $attrData['deleted'] == '1') {
                        if (!empty($attrData['id'])) {
                            ProductAttribute::where('id', $attrData['id'])
                                ->where('product_id', $product->id)
                                ->delete();
                        }
                        continue;
                    }

                    $hasValidAttribute = true;

                    // Update existing or create new
                    if (!empty($attrData['id'])) {
                        ProductAttribute::where('id', $attrData['id'])
                            ->where('product_id', $product->id)
                            ->update([
                                'size' => $attrData['size'] ?? null,
                                'color' => $attrData['color'] ?? null,
                                'price' => $attrData['price'],
                                'quantity' => $attrData['quantity'],
                            ]);
                    } else {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'size' => $attrData['size'] ?? null,
                            'color' => $attrData['color'] ?? null,
                            'price' => $attrData['price'],
                            'quantity' => $attrData['quantity'],
                        ]);
                    }
                }

                // Ensure at least one attribute remains
                if (!$hasValidAttribute) {
                    throw new \Exception('Sản phẩm phải có ít nhất một phân loại!');
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Rollback: Xóa các ảnh đã upload trên Cloudinary
            foreach ($uploadedPublicIds as $publicId) {
                try {
                    Cloudinary::destroy($publicId);
                } catch (\Exception $deleteError) {
                    Log::warning('Failed to rollback image deletion: ' . $deleteError->getMessage());
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        
        try {
            // Xóa images từ Cloudinary
            foreach ($product->images as $image) {
                if (!empty($image->image_url)) {
                    try {
                        Cloudinary::destroy($image->image_url); // image_url chứa public_id
                    } catch (\Exception $e) {
                        // Log error nhưng vẫn tiếp tục xóa
                        Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
                    }
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
            $productId = $image->product_id;
            
            // Check if this is the main image
            if ($image->is_main) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa ảnh chính! Vui lòng đặt ảnh khác làm ảnh chính trước.'
                ], 400);
            }

            // Check if this is the last image
            $imageCount = ProductImage::where('product_id', $productId)->count();
            if ($imageCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa ảnh cuối cùng của sản phẩm!'
                ], 400);
            }
            
            // Delete from Cloudinary
            if (!empty($image->image_url)) {
                try {
                    Cloudinary::destroy($image->image_url); // image_url chứa public_id
                } catch (\Exception $e) {
                    Log::warning('Failed to delete image from Cloudinary: ' . $e->getMessage());
                }
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

            DB::beginTransaction();
            
            // Remove main flag from all images of this product
            ProductImage::where('product_id', $productId)->update(['is_main' => 0]);
            
            // Set this image as main
            $image->update(['is_main' => 1]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã đặt làm ảnh chính!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}