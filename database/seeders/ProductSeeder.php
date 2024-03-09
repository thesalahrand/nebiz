<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(10)
            ->has(Sku::factory()->count(1))
            ->create();
        Product::factory()->count(5)
            ->has(Sku::factory()->count(2))
            ->create();
        Product::factory()->count(5)
            ->has(Sku::factory()->count(3))
            ->create();
    }
}
