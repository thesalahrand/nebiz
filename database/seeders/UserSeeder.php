<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAddress;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(User::SEED_AMOUNT / 2)->create();

        User::factory()->count(User::SEED_AMOUNT / 2)->has(
            UserAddress::factory()->count(UserAddress::SEED_AMOUNT_PER_USER),
            'addresses'
        )->create();
    }
}
