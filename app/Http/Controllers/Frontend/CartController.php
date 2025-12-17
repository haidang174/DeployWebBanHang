<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => null]
            );
        } else {
            $sessionId = session()->getId();
            if (!$sessionId) {
                session()->regenerate();
                $sessionId = session()->getId();
            }
            
            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId],
                ['user_id' => null]
            );
        }

        return $cart;
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with(['product.mainImage', 'productAttribute'])->get();

        return view('frontend.cart.index', compact('cart', 'cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_attribute_id' => 'required|exists:product_attributes,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $attribute = ProductAttribute::findOrFail($request->product_attribute_id);

        // Kiểm tra tồn kho
        if ($attribute->quantity < $request->quantity) {
            return back()->with('error', 'Số lượng sản phẩm không đủ!');
        }

        $cart = $this->getOrCreateCart();

        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_attribute_id', $attribute->id)
            ->first();

        if ($cartItem) {
            // Cập nhật số lượng
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($attribute->quantity < $newQuantity) {
                return back()->with('error', 'Số lượng sản phẩm không đủ!');
            }
            
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // Thêm mới
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_attribute_id' => $attribute->id,
                'quantity' => $request->quantity,
                'price' => $attribute->price,
            ]);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($id);

        // Kiểm tra tồn kho
        if ($cartItem->productAttribute->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng sản phẩm không đủ!'
            ], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $cart = $cartItem->cart;

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật giỏ hàng!',
            'item_total' => number_format($cartItem->total, 0, ',', '.'),
            'cart_subtotal' => number_format($cart->subtotal, 0, ',', '.'),
            'cart_total_items' => $cart->total_items,
        ]);
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->clearCart();

        return back()->with('success', 'Đã xóa tất cả sản phẩm trong giỏ hàng!');
    }

    public function count()
    {
        $cart = $this->getOrCreateCart();
        
        return response()->json([
            'count' => $cart->total_items
        ]);
    }
}