<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
                [
                    'name'=>'Nokia',
                    'category'=>'Mobile phone',
                    'price' => 2000000,
                    'description' => 'The hardess phone in the Earth',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name'=>'Iphone 16 promax',
                    'category'=>'Mobile phone',
                    'price' => 50000000,
                    'description' => 'The most popular phone in the Earth',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]);
        Product::factory(10)->create();
    }
}
