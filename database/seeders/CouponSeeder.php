<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 200000,
            'max_discount_amount' => 50000,
            'usage_limit' => 100,
            'usage_per_user' => 1,
            'used_count' => 5,
            'start_date' => Carbon::now()->subDays(7),
            'end_date' => Carbon::now()->addMonths(1),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SUMMER50K',
            'type' => 'fixed',
            'value' => 50000,
            'min_order_amount' => 500000,
            'max_discount_amount' => null,
            'usage_limit' => 50,
            'usage_per_user' => 1,
            'used_count' => 12,
            'start_date' => Carbon::now()->subDays(3),
            'end_date' => Carbon::now()->addMonths(2),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'type' => 'fixed',
            'value' => 30000,
            'min_order_amount' => 300000,
            'max_discount_amount' => null,
            'usage_limit' => 200,
            'usage_per_user' => 3,
            'used_count' => 45,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'MEGA20',
            'type' => 'percentage',
            'value' => 20,
            'min_order_amount' => 1000000,
            'max_discount_amount' => 200000,
            'usage_limit' => 30,
            'usage_per_user' => 1,
            'used_count' => 8,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addWeeks(2),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'EXPIRED',
            'type' => 'percentage',
            'value' => 15,
            'min_order_amount' => 200000,
            'max_discount_amount' => 100000,
            'usage_limit' => 50,
            'usage_per_user' => 1,
            'used_count' => 50,
            'start_date' => Carbon::now()->subMonths(2),
            'end_date' => Carbon::now()->subDays(1),
            'is_active' => false,
        ]);
    }
}