<?php

namespace Database\Factories;

use App\Enums\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randStoreIdOfFirstUser = User::find(1)->stores->pluck('id')->shuffle()->first();

        return [
            'store_id' => $randStoreIdOfFirstUser,
            'brand_id' => fake()->numberBetween(1, Brand::count()),
            'name' => fake()->words(2, true),
            'slug' => fake()->unique(true)->slug,
            'unit_name' => fake()->randomElement(array_column(Unit::cases(), 'value')),
            'additional_info' => fake()->sentence()
        ];
    }
}
