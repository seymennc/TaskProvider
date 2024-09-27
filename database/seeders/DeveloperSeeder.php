<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Developer::insert([
            [
                'name' => 'Developer 1',
                'hourly_capacity' => 1,
                'difficulty_multiplier' => 1,
            ],
            [
                'name' => 'Developer 2',
                'hourly_capacity' => 1,
                'difficulty_multiplier' => 2,
            ],
            [
                'name' => 'Developer 3',
                'hourly_capacity' => 1,
                'difficulty_multiplier' => 3,
            ],
            [
                'name' => 'Developer 4',
                'hourly_capacity' => 1,
                'difficulty_multiplier' => 4,
            ],
            [
                'name' => 'Developer 5',
                'hourly_capacity' => 1,
                'difficulty_multiplier' => 5,
            ],
        ]);
    }
}
