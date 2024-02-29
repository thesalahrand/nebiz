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
        StoreType::factory()->count(15)
            ->has(Store::factory()->count(3)
                ->has(StoreOpeningHour::factory()->count(7), 'openingHours'))
            ->create();
    }
}
