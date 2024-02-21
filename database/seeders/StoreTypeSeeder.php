<?php

namespace Database\Seeders;

use App\Models\StoreType;
use App\Models\Store;
use App\Models\StoreOpeningHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreType::factory()->count(StoreType::SEED_AMOUNT)
            ->has(Store::factory()->count(Store::SEED_AMOUNT_PER_STORE_TYPE)
                ->has(StoreOpeningHour::factory()->count(StoreOpeningHour::SEED_AMOUNT_PER_STORE), 'openingHours'))
            ->create();
    }
}
