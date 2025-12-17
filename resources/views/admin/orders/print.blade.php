<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Đơn Hàng {{ $order->order_code }}</title>
    <style>
          * {
               margin: 0;
               padding: 0;
               box-sizing: border-box;
          }

          body {
               font-family: 'DejaVu Sans', Arial, sans-serif;
               font-size: 14px;
               line-height: 1.6;
               color: #333;
               padding: 20px;
          }

          .invoice-container {
               max-width: 800px;
               margin: 0 auto;
               background: white;
               padding: 40px;
          }

          .invoice-header {
               display: flex;
               justify-content: space-between;
               align-items: start;
               padding-bottom: 30px;
               border-bottom: 3px solid #2563eb;
               margin-bottom: 30px;
          }

          .company-info h1 {
               font-size: 28px;
               color: #2563eb;
               margin-bottom: 5px;
          }

          .company-info p {
               font-size: 12px;
               color: #666;
               margin: 2px 0;
          }

          .invoice-title {
               text-align: right;
          }

          .invoice-title h2 {
               font-size: 32px;
               color: #2563eb;
               margin-bottom: 5px;
          }

          .invoice-title p {
               font-size: 14px;
               color: #666;
          }

          .info-section {
               display: flex;
               justify-content: space-between;
               margin-bottom: 30px;
          }

          .info-box {
               width: 48%;
          }

          .info-box h3 {
               font-size: 16px;
               color: #2563eb;
               margin-bottom: 10px;
               padding-bottom: 5px;
               border-bottom: 2px solid #e5e7eb;
          }

          .info-box p {
               margin: 5px 0;
               font-size: 13px;
          }

          .info-box strong {
               display: inline-block;
               width: 120px;
               color: #666;
          }

          .status-badge {
               display: inline-block;
               padding: 4px 12px;
               border-radius: 20px;
               font-size: 12px;
               font-weight: bold;
          }

          .status-pending { background: #fef3c7; color: #92400e; }
          .status-confirmed { background: #dbeafe; color: #1e40af; }
          .status-processing { background: #e0e7ff; color: #4338ca; }
          .status-shipping { background: #e9d5ff; color: #6b21a8; }
          .status-delivered { background: #d1fae5; color: #065f46; }
          .status-cancelled { background: #fee2e2; color: #991b1b; }

          .payment-paid { background: #d1fae5; color: #065f46; }
          .payment-pending { background: #fef3c7; color: #92400e; }
          .payment-failed { background: #fee2e2; color: #991b1b; }
          .payment-refunded { background: #e9d5ff; color: #6b21a8; }

          table {
               width: 100%;
               border-collapse: collapse;
               margin-bottom: 20px;
          }

          table thead {
               background: #f3f4f6;
          }

          table th {
               padding: 12px;
               text-align: left;
               font-size: 12px;
               font-weight: 600;
               color: #374151;
               border-bottom: 2px solid #e5e7eb;
          }

          table td {
               padding: 12px;
               border-bottom: 1px solid #e5e7eb;
               font-size: 13px;
          }

          table tbody tr:hover {
               background: #f9fafb;
          }

          .product-info {
               display: flex;
               align-items: center;
               gap: 10px;
          }

          .product-image {
               width: 50px;
               height: 50px;
               object-fit: cover;
               border-radius: 5px;
               border: 1px solid #e5e7eb;
          }

          .product-details {
               flex: 1;
          }

          .product-name {
               font-weight: 600;
               color: #111827;
               margin-bottom: 3px;
          }

          .product-variant {
               font-size: 11px;
               color: #6b7280;
          }

          .text-right {
               text-align: right;
          }

          .text-center {
               text-align: center;
          }

          .summary-table {
               width: 100%;
               max-width: 400px;
               margin-left: auto;
               margin-top: 20px;
          }

          .summary-table td {
               padding: 8px 12px;
               border: none;
          }

          .summary-table .label {
               text-align: right;
               color: #6b7280;
               font-weight: 500;
          }

          .summary-table .value {
               text-align: right;
               font-weight: 600;
          }

          .summary-table .total-row {
               border-top: 2px solid #2563eb;
               font-size: 18px;
               color: #2563eb;
          }

          .notes-section {
               margin-top: 30px;
               padding: 15px;
               background: #f9fafb;
               border-left: 4px solid #2563eb;
               border-radius: 4px;
          }

          .notes-section h4 {
               color: #2563eb;
               margin-bottom: 8px;
               font-size: 14px;
          }

          .notes-section p {
               color: #4b5563;
               font-size: 13px;
          }

          .footer {
               margin-top: 40px;
               padding-top: 20px;
               border-top: 2px solid #e5e7eb;
               text-align: center;
               color: #6b7280;
               font-size: 12px;
          }

          .signature-section {
               display: flex;
               justify-content: space-between;
               margin-top: 60px;
               padding-top: 20px;
          }

          .signature-box {
               text-align: center;
               width: 45%;
          }

          .signature-box p {
               margin-bottom: 60px;
               font-weight: 600;
               color: #374151;
          }

          .signature-line {
               border-top: 1px solid #374151;
               padding-top: 5px;
               font-size: 12px;
               color: #6b7280;
          }

          @media print {
               body {
                    padding: 0;
               }

               .invoice-container {
                    padding: 20px;
               }

               .no-print {
                    display: none;
               }

               @page {
                    margin: 1cm;
               }
          }

          .print-button {
               position: fixed;
               top: 20px;
               right: 20px;
               padding: 12px 24px;
               background: #2563eb;
               color: white;
               border: none;
               border-radius: 8px;
               cursor: pointer;
               font-size: 14px;
               font-weight: 600;
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
               z-index: 1000;
          }

          .print-button:hover {
               background: #1d4ed8;
          }

          .print-button i {
               margin-right: 8px;
          }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
     <button onclick="window.print()" class="print-button no-print">
          <i class="fas fa-print"></i>
          In Đơn Hàng
     </button>

     <div class="invoice-container">
          <!-- Header -->
          <div class="invoice-header">
               <div class="company-info">
                    <h1>Fashion Shop</h1>
                    <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: 180 Cao Lỗ, Quận 8, TP.HCM</p>
                    <p><i class="fas fa-phone"></i> Hotline: 0123 456 789</p>
                    <p><i class="fas fa-envelope"></i> Email: info@fashionshop.vn</p>
                    <p><i class="fas fa-globe"></i> Website: www.FashionShop.com</p>
               </div>
               <div class="invoice-title">
                    <h2>HÓA ĐƠN</h2>
                    <p>{{ $order->order_code }}</p>
                    <p style="margin-top: 10px; font-size: 12px;">
                         <strong>Ngày:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                    </p>
               </div>
          </div>

          <!-- Info Section -->
          <div class="info-section">
               <div class="info-box">
                    <h3><i class="fas fa-user"></i> Thông Tin Khách Hàng</h3>
                    <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
               </div>
               <div class="info-box">
                    <h3><i class="fas fa-info-circle"></i> Thông Tin Đơn Hàng</h3>
                    <p>
                         <strong>Trạng thái:</strong> 
                         @if($order->status == 'pending')
                         <span class="status-badge status-pending">Chờ xác nhận</span>
                         @elseif($order->status == 'confirmed')
                         <span class="status-badge status-confirmed">Đã xác nhận</span>
                         @elseif($order->status == 'processing')
                         <span class="status-badge status-processing">Đang xử lý</span>
                         @elseif($order->status == 'shipping')
                         <span class="status-badge status-shipping">Đang giao</span>
                         @elseif($order->status == 'delivered')
                         <span class="status-badge status-delivered">Đã giao</span>
                         @elseif($order->status == 'cancelled')
                         <span class="status-badge status-cancelled">Đã hủy</span>
                         @endif
                    </p>
                    <p>
                         <strong>Thanh toán:</strong> 
                         @if($order->payment_status == 'paid')
                         <span class="status-badge payment-paid">Đã thanh toán</span>
                         @elseif($order->payment_status == 'pending')
                         <span class="status-badge payment-pending">Chờ thanh toán</span>
                         @elseif($order->payment_status == 'failed')
                         <span class="status-badge payment-failed">Thất bại</span>
                         @elseif($order->payment_status == 'refunded')
                         <span class="status-badge payment-refunded">Hoàn tiền</span>
                         @endif
                    </p>
                    <p>
                         <strong>Phương thức:</strong> 
                         @if($order->payment_method == 'cod')
                         COD - Thanh toán khi nhận hàng
                         @elseif($order->payment_method == 'momo')
                         Ví MoMo
                         @endif
                    </p>
                    @if($order->payment_code)
                    <p><strong>Mã thanh toán:</strong> {{ $order->payment_code }}</p>
                    @endif
               </div>
          </div>

          <!-- Products Table -->
          <table>
               <thead>
                    <tr>
                         <th style="width: 50px;">STT</th>
                         <th>Sản Phẩm</th>
                         <th class="text-center" style="width: 100px;">Số Lượng</th>
                         <th class="text-right" style="width: 120px;">Đơn Giá</th>
                         <th class="text-right" style="width: 120px;">Thành Tiền</th>
                    </tr>
               </thead>
               <tbody>
                    @foreach($order->orderDetails as $index => $detail)
                    <tr>
                         <td class="text-center">{{ $index + 1 }}</td>
                         <td>
                         <div class="product-info">
                              @if($detail->product_image)
                                   <img src="{{ asset('storage/' . $detail->product_image) }}" 
                                        alt="{{ $detail->product_name }}" 
                                        class="product-image">
                              @endif
                              <div class="product-details">
                                   <div class="product-name">{{ $detail->product_name }}</div>
                                   @if($detail->size || $detail->color)
                                        <div class="product-variant">
                                             @if($detail->size)
                                             Size: {{ $detail->size }}
                                             @endif
                                             @if($detail->size && $detail->color) | @endif
                                             @if($detail->color)
                                             Màu: {{ $detail->color }}
                                             @endif
                                        </div>
                                   @endif
                              </div>
                         </div>
                         </td>
                         <td class="text-center">{{ $detail->quantity }}</td>
                         <td class="text-right">{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                         <td class="text-right"><strong>{{ number_format($detail->total, 0, ',', '.') }}đ</strong></td>
                    </tr>
                    @endforeach
               </tbody>
          </table>

          <!-- Summary -->
          <table class="summary-table">
               <tr>
                    <td class="label">Tạm tính:</td>
                    <td class="value">{{ number_format($order->subtotal, 0, ',', '.') }}đ</td>
               </tr>
               <tr>
                    <td class="label">Phí vận chuyển:</td>
                    <td class="value">{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</td>
               </tr>
               @if($order->discount_amount > 0)
               <tr>
                    <td class="label">
                         Giảm giá:
                         @if($order->coupon)
                         <span style="font-size: 11px; color: #10b981;">({{ $order->coupon->code }})</span>
                         @endif
                    </td>
                    <td class="value" style="color: #10b981;">-{{ number_format($order->discount_amount, 0, ',', '.') }}đ</td>
               </tr>
               @endif
               <tr class="total-row">
                    <td class="label">TỔNG CỘNG:</td>
                    <td class="value">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
               </tr>
          </table>

          <!-- Notes -->
          @if($order->notes)
          <div class="notes-section">
               <h4><i class="fas fa-sticky-note"></i> Ghi Chú</h4>
               <p>{{ $order->notes }}</p>
          </div>
          @endif

          <!-- Signature Section -->
          <div class="signature-section">
               <div class="signature-box">
                    <p>Người Mua Hàng</p>
                    <div class="signature-line">(Ký và ghi rõ họ tên)</div>
               </div>
               <div class="signature-box">
                    <p>Người Bán Hàng</p>
                    <div class="signature-line">(Ký và ghi rõ họ tên)</div>
               </div>
          </div>

          <!-- Footer -->
          <div class="footer">
               <p><strong>Cảm ơn quý khách đã mua hàng!</strong></p>
               <p style="margin-top: 5px;">Mọi thắc mắc vui lòng liên hệ: 0123 456 789 hoặc info@fashionshop.vn</p>
               <p style="margin-top: 10px; font-size: 11px; color: #9ca3af;">
                    Hóa đơn được in tự động từ hệ thống - {{ now()->format('d/m/Y H:i:s') }}
               </p>
          </div>
     </div>

     <script>
          // Auto print when page loads (optional)
          // window.onload = function() { window.print(); }
     </script>
</body>
</html>