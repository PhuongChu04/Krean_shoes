<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin\Order;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;
    public function definition(): array
    {
        return [
            'user_id' => null, // hoặc User::factory()
        'order_code' => 'DH' . fake()->unique()->numerify('######'),
        'subtotal' => fake()->randomFloat(2, 500000, 5000000),
        'discount_amount' => 0,
        'shipping_fee' => fake()->randomElement([0, 30000, 50000]),
        'total_amount' => fake()->randomFloat(2, 550000, 5500000),
        'status' => fake()->randomElement(['pending', 'confirmed', 'shipped', 'delivered', 'cancelled']),
        'payment_method' => 'cod',
        'payment_status' => fake()->randomElement(['pending', 'paid']),
        'receiver_name' => fake()->name(),
        'receiver_phone' => fake()->phoneNumber(),
        'receiver_address' => fake()->address(),
        'note' => fake()->sentence(),
        ];
    }
    // State hữu ích cho test
    public function pendingCod()
    {
        return $this->state(fn () => [
            'status'         => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
        ]);
    }

    public function delivered()
    {
        return $this->state(fn () => [
            'status'         => 'delivered',
            'payment_status' => 'paid',
        ]);
    }
}
