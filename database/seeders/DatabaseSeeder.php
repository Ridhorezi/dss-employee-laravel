<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DivisionSeeder::class,
            EmployeeSeeder::class,
            CriteriaSeeder::class,
            SubcriteriaSeeder::class,
            CriteriaComparisonSeeder::class,
            SubcriteriaComparisonSeeder::class,
            // AssessmentSeeder::class,
            // SpkSeeder::class
        ]);
    }
}