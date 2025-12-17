<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MoMoController extends Controller
{
     public function return(Request $request)
     {
          $resultCode = $request->input('resultCode');
          $orderId = $request->input('orderId');
          $message = $request->input('message');
          
          // Tìm order
          $order = Order::where('order_code', $orderId)->first();
          
          if (!$order) {
               Log::error("Order not found: {$orderId}");
               return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng!');
          }
          
          if ($resultCode == 0) {
               try {
                    // ✅ TRỪ TỒN KHO KHI THANH TOÁN THÀNH CÔNG
                    $order->load('orderDetails.productAttribute');
                    
                    foreach ($order->orderDetails as $detail) {
                         $detail->productAttribute->decreaseStock($detail->quantity);
                    }
                    
                    // Cập nhật order status
                    $order->update([
                         'payment_status' => 'paid',
                         'status' => 'confirmed'
                    ]);
                    
                    // Cập nhật transaction
                    $transaction = PaymentTransaction::where('order_id', $order->id)->first();
                    if ($transaction) {
                         $transaction->update([
                         'status' => 'success',
                         'momo_trans_id' => $request->input('transId'),
                         'momo_response' => json_encode($request->all())
                         ]);
                    } else {
                         Log::warning('Transaction not found for order: ' . $order->id);
                    }
                    
                    return redirect()->route('order.success', $order->id)
                         ->with('success', 'Thanh toán thành công!');
                         
               } catch (\Exception $e) {
                    Log::error('Error processing successful payment: ' . $e->getMessage());
                    Log::error($e->getTraceAsString());
                    return redirect()->route('home')->with('error', 'Có lỗi xảy ra khi xử lý thanh toán!');
               }
               
          } else {
               try {
                    // ✅ KHÔNG CẦN HOÀN TỒN KHO VÌ CHƯA BỊ TRỪ
                    
                    // Cập nhật order status
                    $order->update([
                         'payment_status' => 'failed',
                         'status' => 'cancelled'
                    ]);
                    
                    // Cập nhật transaction
                    $transaction = PaymentTransaction::where('order_id', $order->id)->first();
                    if ($transaction) {
                         $transaction->update([
                         'status' => 'failed',
                         'error_message' => $message ?: 'Payment failed',
                         'momo_response' => json_encode($request->all())
                         ]);
                    }
                    
                    return redirect()->route('order.failed', $order->id)
                         ->with('error', $message ?: 'Thanh toán thất bại hoặc đã bị hủy!');
                         
               } catch (\Exception $e) {
                    Log::error('Error processing failed payment: ' . $e->getMessage());
                    return redirect()->route('home')->with('error', 'Có lỗi xảy ra!');
               }
          }
     }
    
     public function notify(Request $request)
     {
          $orderId = $request->input('orderId');
          $resultCode = $request->input('resultCode');
          
          // Tìm order
          $order = Order::where('order_code', $orderId)->first();
          
          if ($order && $resultCode == 0) {
               // Kiểm tra xem đã trừ tồn kho chưa (tránh trừ 2 lần)
               if ($order->payment_status !== 'paid') {
                    $order->load('orderDetails.productAttribute');
                    
                    foreach ($order->orderDetails as $detail) {
                         $detail->productAttribute->decreaseStock($detail->quantity);
                    }
                    
                    $order->update([
                         'payment_status' => 'paid',
                         'status' => 'confirmed'
                    ]);
                    
                    PaymentTransaction::where('order_id', $order->id)
                         ->update([
                         'status' => 'success',
                         'momo_trans_id' => $request->input('transId'),
                         'momo_response' => json_encode($request->all())
                         ]);
               }
          }
          
          return response()->json(['message' => 'OK']);
     }
}