<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\StoreOpeningHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreOpeningHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::inRandomOrder()->limit(StoreOpeningHour::SEED_AMOUNT / 7)->get();

        $stores->each(function (Store $store, int $key) {
            for ($dayOfWeek = 0; $dayOfWeek <= 6; $dayOfWeek++) {
                StoreOpeningHour::factory()->create([
                    'store_id' => $store->id,
                    'day_of_week' => $dayOfWeek
                ]);
            }
        });
    }
}
