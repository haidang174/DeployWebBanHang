<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductAttribute;
use App\Models\User;
use App\Models\Coupon;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $statuses = ['pending', 'confirmed', 'processing', 'shipping', 'delivered', 'cancelled'];
        $paymentMethods = ['cod', 'momo'];
        $paymentStatuses = ['pending', 'paid', 'failed'];

        for ($i = 1; $i <= 20; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            
            // Nếu delivered thì payment_status = paid
            $paymentStatus = $status === 'delivered' ? 'paid' : $paymentStatuses[array_rand($paymentStatuses)];

            // Random 2-5 sản phẩm
            $attributes = ProductAttribute::inRandomOrder()->take(rand(2, 5))->get();
            
            $subtotal = 0;
            $orderDetails = [];

            foreach ($attributes as $attr) {
                $quantity = rand(1, 3);
                $price = $attr->price;
                $total = $price * $quantity;
                $subtotal += $total;

                $orderDetails[] = [
                    'product_attribute_id' => $attr->id,
                    'product_name' => $attr->product->product_name,
                    'product_image' => $attr->product->main_image_url,
                    'size' => $attr->size,
                    'color' => $attr->color,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $total,
                ];
            }

            $shippingFee = 30000;
            $discountAmount = 0;
            $couponId = null;

            // 30% đơn hàng có coupon
            if (rand(1, 10) <= 3) {
                $coupon = Coupon::where('is_active', true)->inRandomOrder()->first();
                if ($coupon && $subtotal >= $coupon->min_order_amount) {
                    $couponId = $coupon->id;
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                }
            }

            $totalAmount = $subtotal + $shippingFee - $discountAmount;

            $order = Order::create([
                'order_code' => 'ORD' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'coupon_id' => $couponId,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '0' . rand(900000000, 999999999),
                'customer_address' => $this->randomAddress(),
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'payment_code' => $paymentMethod === 'momo' ? 'MOMO' . rand(100000, 999999) : null,
                'notes' => rand(0, 1) ? $this->randomNote() : null,
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);

            // Tạo order details
            foreach ($orderDetails as $detail) {
                OrderDetail::create(array_merge(['order_id' => $order->id], $detail));
            }
        }
    }

    private function randomAddress(): string
    {
        $streets = [
            '123 Nguyễn Huệ',
            '456 Lê Lợi',
            '789 Trần Hưng Đạo',
            '321 Hai Bà Trưng',
            '654 Lý Thường Kiệt',
            '987 Võ Văn Tần',
        ];

        $districts = [
            'Quận 1',
            'Quận 3',
            'Quận 5',
            'Quận Tân Bình',
            'Quận Phú Nhuận',
            'Quận Bình Thạnh',
        ];

        return $streets[array_rand($streets)] . ', ' . $districts[array_rand($districts)] . ', TP.HCM';
    }

    private function randomNote(): string
    {
        $notes = [
            'Giao hàng buổi sáng',
            'Gọi trước khi giao',
            'Để trước cửa',
            'Giao vào cuối tuần',
            'Gói kỹ giúp em',
        ];

        return $notes[array_rand($notes)];
    }
}