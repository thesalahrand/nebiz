<?php

namespace Database\Factories;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributeValue>
 */
class ProductAttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_attribute_id' => ProductAttribute::factory(),
            'name' => ucfirst(fake()->word()),
            'additional_info' => fake()->sentence()
        ];
    }
}
