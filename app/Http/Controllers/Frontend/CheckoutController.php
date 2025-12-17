<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Coupon;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $cartItems = $cart->items()->with(['product.mainImage', 'productAttribute'])->get();
        $user = Auth::user();

        return view('frontend.checkout.index', compact('cart', 'cartItems', 'user'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        $cart = $this->getCart();
        $subtotal = $cart->subtotal;

        if ($subtotal < $coupon->min_order_amount) {
            return back()->with('error', "Đơn hàng tối thiểu " . number_format($coupon->min_order_amount) . "đ để sử dụng mã này!");
        }

        $discount = $coupon->calculateDiscount($subtotal);

        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount,
        ]]);

        return back()->with('success', 'Đã áp dụng mã giảm giá!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Đã xóa mã giảm giá!');
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cod,momo',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = $this->getCart();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        
        try {
            $subtotal = $cart->subtotal;
            $shippingFee = 30000; // 30k phí ship cố định
            $discountAmount = 0;
            $couponId = null;

            // Áp dụng coupon nếu có
            if (session()->has('coupon')) {
                $couponData = session('coupon');
                $couponId = $couponData['id'];
                $discountAmount = $couponData['discount'];
            }

            $totalAmount = $subtotal + $shippingFee - $discountAmount;

            // Tạo order
            $order = Order::create([
                'order_code' => Order::generateOrderCode(),
                'user_id' => Auth::id(),
                'coupon_id' => $couponId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Tạo order details
            foreach ($cart->items as $item) {
                // Kiểm tra tồn kho
                if ($item->productAttribute->quantity < $item->quantity) {
                    throw new \Exception("Sản phẩm {$item->product->product_name} không đủ số lượng!");
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_attribute_id' => $item->product_attribute_id,
                    'product_name' => $item->product->product_name,
                    'product_image' => $item->product->main_image_url,
                    'size' => $item->productAttribute->size,
                    'color' => $item->productAttribute->color,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                ]);

                // CHỈ TRỪ TỒN KHO KHI THANH TOÁN COD
                // MoMo sẽ trừ khi callback thành công
                if ($request->payment_method === 'cod') {
                    $item->productAttribute->decreaseStock($item->quantity);
                }
            }

            // Cập nhật coupon usage
            if ($couponId) {
                $coupon = Coupon::find($couponId);
                $coupon->incrementUsage();
            }

            // Xóa giỏ hàng
            $cart->clearCart();
            session()->forget('coupon');

            DB::commit();

            // Xử lý thanh toán
            if ($request->payment_method === 'momo') {
                return $this->processMomoPayment($order);
            }

            // COD - đã trừ tồn kho rồi
            return redirect()->route('order.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    private function processMomoPayment($order)
    {
        try {
            // Tạo payment transaction
            $transaction = PaymentTransaction::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'status' => 'pending',
                'transaction_id' => PaymentTransaction::generateTransactionId(),
                'payment_method' => 'momo',
            ]);

            // Cấu hình MoMo
            $orderId = $order->order_code;
            $amount = (int)round($order->total_amount);
            $orderInfo = 'Thanh toán đơn hàng ' . $orderId;
            $requestId = time() . "";
            
            $partnerCode = env('MOMO_PARTNER_CODE');
            $accessKey = env('MOMO_ACCESS_KEY');
            $secretKey = env('MOMO_SECRET_KEY');
            $endpoint = env('MOMO_ENDPOINT');
            $returnUrl = route('momo.return');
            $notifyUrl = route('momo.notify');
            $requestType = "captureWallet";
            $extraData = $transaction->transaction_id;
            
            // Tạo chữ ký
            $rawHash = "accessKey=" . $accessKey . 
                    "&amount=" . $amount . 
                    "&extraData=" . $extraData . 
                    "&ipnUrl=" . $notifyUrl . 
                    "&orderId=" . $orderId . 
                    "&orderInfo=" . $orderInfo . 
                    "&partnerCode=" . $partnerCode . 
                    "&redirectUrl=" . $returnUrl . 
                    "&requestId=" . $requestId . 
                    "&requestType=" . $requestType;
            
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            
            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Fashion Shop",
                'storeId' => "FashionStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $returnUrl,
                'ipnUrl' => $notifyUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];
            
            $result = $this->execPostRequest($endpoint, json_encode($data));
            
            if (!$result) {
                Log::error('MoMo Response is empty or null');
                throw new \Exception('Không nhận được phản hồi từ MoMo');
            }
            
            $jsonResult = json_decode($result, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error: ' . json_last_error_msg());
                Log::error('Raw response: ' . $result);
                throw new \Exception('Không thể parse response từ MoMo');
            }
            
            if (isset($jsonResult['payUrl'])) {
                // Lưu requestId và response
                $transaction->update([
                    'request_id' => $requestId,
                    'momo_response' => json_encode($jsonResult),
                ]);
                
                return redirect($jsonResult['payUrl']);
            } else {
                // Lỗi từ MoMo
                $errorMessage = $jsonResult['message'] ?? 'Unknown error';
                $resultCode = $jsonResult['resultCode'] ?? 'N/A';
                
                Log::error('MoMo Error: ' . $errorMessage . ' (Code: ' . $resultCode . ')');
                
                $transaction->update([
                    'status' => 'failed',
                    'error_message' => $errorMessage,
                    'momo_response' => json_encode($jsonResult ?? []),
                ]);
                
                throw new \Exception('Không thể tạo thanh toán MoMo: ' . $errorMessage . ' (Code: ' . $resultCode . ')');
            }
            
        } catch (\Exception $e) {
            Log::error('MoMo Payment Exception: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Rollback order nếu lỗi
            $order->update(['status' => 'cancelled']);
            
            return redirect()->route('checkout.index')
                ->with('error', 'Không thể kết nối đến cổng thanh toán MoMo. Vui lòng thử lại!');
        }
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        
        $result = curl_exec($ch);
        
        if ($result === false) {
            $error = curl_error($ch);
            Log::error('CURL Error: ' . $error);
            
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            Log::error('CURL Verbose: ' . $verboseLog);
        }
        
        curl_close($ch);
        fclose($verbose);
        
        return $result;
    }

    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        } else {
            return Cart::where('session_id', session()->getId())->first();
        }
    }
}