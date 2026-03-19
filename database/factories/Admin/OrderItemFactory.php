<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin\ProductVariant;
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 150000, 3000000);

        return [
            'order_id'           => null, // sẽ gán khi create
            'product_variant_id' => ProductVariant::inRandomOrder()->first()?->id ?? 1,
            'quantity'           => $this->faker->numberBetween(1, 5),
            'price'              => $price,
            'subtotal'           => fn (array $attr) => $attr['quantity'] * $price,
        ];
    }
}