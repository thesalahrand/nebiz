<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\StoreType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    private static int $storesPerUser = 5;
    private static int $counter = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => ceil(static::$counter++ / static::$storesPerUser),
            'store_type_id' => StoreType::factory(),
            'name' => fake()->company,
            'slug' => fake()->unique(true)->slug,
            'address' => fake()->streetAddress,
            'area' => fake()->citySuffix,
            'city' => fake()->city,
            'postal_code' => fake()->postcode,
            'phone' => fake()->regexify('1[3456789]\d{8}'),
            'email' => fake()->safeEmail,
            'website' => fake()->domainName,
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'additional_info' => fake()->sentence(),
        ];
    }
}
