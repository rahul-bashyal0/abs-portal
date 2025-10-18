<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\College; // Use the College model

class AbsSoftInstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create the special "ABS Soft Pvt. Ltd" institute.
        // This prevents duplicates if you run the seeder more than once.
        College::firstOrCreate(
            ['name' => 'ABS Soft Pvt. Ltd'],
            ['city' => 'Corporate', 'state' => 'HQ']
        );
    }
}