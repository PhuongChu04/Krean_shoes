<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin Krean',
            'email' => 'admin@krean.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'role' => '1',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User thường
        DB::table('users')->insert([
            'name' => 'User Krean',
            'email' => 'user@krean.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('123456'),
            'role' => '2',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
