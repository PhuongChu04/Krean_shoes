<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class VoucherFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(['fixed', 'percentage']);

        return [
            'name'            => 'Giảm ' . $this->faker->randomElement(['50k', '100k', '20%', '30%']),
            'code'            => strtoupper($this->faker->unique()->lexify('PROMO??????')),
            'description'     => $this->faker->sentence(8),
            'type'            => $type,
            'quantity'        => $this->faker->numberBetween(5, 100),
            'discount_amount' => $type === 'percentage' ? $this->faker->numberBetween(5, 50) : $this->faker->numberBetween(20000, 300000),
            'start_date'      => Carbon::now()->subDays(10),
            'end_date'        => Carbon::now()->addDays($this->faker->numberBetween(5, 60)),
            'status'          => 'active',
        ];
    }

    public function expired()
    {
        return $this->state(fn () => [
            'end_date' => Carbon::now()->subDays(3),
            'status'   => 'expired',
        ]);
    }
}