<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('vouchers')->insert([
            [
                'name' => 'Giảm 10% cho đơn hàng đầu',
                'code' => 'FIRST10',
                'description' => 'Áp dụng cho đơn hàng đầu tiên',
                'type' => 'percent',
                'quantity' => 100,
                'discount_amount' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'status' => 'active',
            ],
            [
                'name' => 'Giảm 200k cho đơn trên 1 triệu',
                'code' => 'SAVE200',
                'description' => 'Giảm giá cho đơn hàng lớn',
                'type' => 'fixed',
                'quantity' => 50,
                'discount_amount' => 200000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(15),
                'status' => 'active',
            ],
        ]);
    }
}
