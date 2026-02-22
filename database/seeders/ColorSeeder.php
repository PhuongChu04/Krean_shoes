<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('colors')->insert([
            ['name' => 'Đen', 'code' => '#000000'],
            ['name' => 'Trắng', 'code' => '#FFFFFF'],
            ['name' => 'Đỏ', 'code' => '#FF0000'],
            ['name' => 'Xanh Dương', 'code' => '#0000FF'],
            ['name' => 'Xanh Lá', 'code' => '#00FF00'],
            ['name' => 'Vàng', 'code' => '#FFFF00'],
        ]);
    }
}
