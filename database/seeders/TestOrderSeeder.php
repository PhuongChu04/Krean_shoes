<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Order;
use App\Models\Admin\OrderItem;
use App\Models\Admin\Payment;
// use Illuminate\Support\Facades\Fake;

class TestOrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory()
            ->count(25)
            ->create()
            ->each(function ($order) {
                // Tạo 1–5 items cho mỗi đơn
                OrderItem::factory()
                    ->count(fake()->numberBetween(1, 5))
                    ->create(['order_id' => $order->id]);

                // Tạo payment cho COD
                if ($order->payment_method === 'cod') {
                    Payment::factory()->create([
                        'order_id' => $order->id,
                        'amount'   => $order->total_amount,
                    ]);
                }
            });

        $this->command->info('Đã tạo 25 đơn hàng mẫu + items + payments!');
    }
}