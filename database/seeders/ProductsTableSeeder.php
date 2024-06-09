<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("products")->insert([
            'product_image' => 'D:\image\rose',
            'product_name' => Str::random(10),
            'product_price' => rand(1, 100),
            'product_description' => Str::random(20),
            'product_discount' => rand(1, 10),
            'product_status' => rand(1, 3),
            'category_id' => rand(1, 4)
        ]);
    }
}
