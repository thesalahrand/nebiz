<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Store;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreOpeningHour>
 */
class StoreOpeningHourFactory extends Factory
{
    private static int $dayOfWeek = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isClosed = fake()->boolean(20);
        $opensClosesAt = [fake()->time('H:i'), fake()->time('H:i')];
        sort($opensClosesAt);

        return [
            'store_id' => Store::factory(),
            'day_of_week' => static::$dayOfWeek++ % 7,
            'is_closed' => $isClosed,
            'opens_at' => $isClosed ? null : $opensClosesAt[0],
            'closes_at' => $isClosed ? null : $opensClosesAt[1],
        ];
    }
}
