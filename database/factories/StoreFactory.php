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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, User::SEED_AMOUNT),
            'store_type_id' => StoreType::factory(),
            'name' => fake()->company,
            'address' => fake()->streetAddress,
            'area' => fake()->citySuffix,
            'city' => fake()->city,
            'postal_code' => fake()->postcode,
            'phone' => fake()->unique(true)->regexify('1[3456789]\d{8}'),
            'email' => fake()->unique(true)->safeEmail,
            'website' => fake()->domainName,
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'additional_info' => fake()->paragraph,
        ];
    }
}
