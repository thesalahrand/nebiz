<?php

namespace Database\Factories;

use App\Enums\DurationUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
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
            'name' => fake()->words(2, true),
            'slug' => fake()->unique(true)->slug,
            'price' => fake()->randomFloat(2, 1, 1000),
            'duration' => fake()->numberBetween(1, 100),
            'duration_unit_name' => fake()->randomElement(array_column(DurationUnit::cases(), 'value')),
            'additional_info' => fake()->sentence()
            //
        ];
    }
}
