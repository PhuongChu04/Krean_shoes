<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id'       => null, // sẽ gán sau
            'amount'         => fn (array $attr) => $attr['order']?->total_amount ?? $this->faker->randomFloat(2, 500000, 5000000),
            'payment_method' => 'cod',
            'status'         => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'transaction_id' => $this->faker->optional()->uuid(),
            'paid_at'        => $this->faker->optional()->dateTimeBetween('-30 days'),
            'note'           => $this->faker->optional()->sentence(),
        ];
    }
}