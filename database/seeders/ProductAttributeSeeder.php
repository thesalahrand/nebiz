<?php

namespace Database\Seeders;

use App\Models\ProductAttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductAttribute::factory()->count(10)
            ->has(ProductAttributeValue::factory()->count(5), 'values')
            ->create();
    }
}
