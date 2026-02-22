<?php

namespace Database\Seeders;

// use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('categories')->insert([
        ['name'=> 'Nam','image'=>'giay-nam.pnj','id_parent'=>null],
        ['name'=>'Nữ','image'=>'giay-nu.pnj','id_parent'=>null],
        [ 'name'=> 'Sneaker Nam', 'image'=>'sneaker-nam.png', 'id_parent'=>1],
        [ 'name'=> 'Sandal Nam', 'image'=>'sandal-nam.png', 'id_parent'=>1],
        [ 'name'=> 'Boot Nam', 'image'=>'boot-nam.png', 'id_parent'=>1],
        
        [ 'name'=> 'Sneaker Nữ', 'image'=>'sneaker-nu.png', 'id_parent'=>2],
        [ 'name'=> 'Sandal Nữ', 'image'=>'sandal-nu.png', 'id_parent'=>2],
        [ 'name'=> 'Boot Nữ', 'image'=>'boot-nu.png', 'id_parent'=>2],
       ]);
    }
}
