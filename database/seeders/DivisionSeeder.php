<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("divisions")->insert([
            [
                "name"       => "IT",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "Finance",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "Sales",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "Accounting",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "Human Resources",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "Engineering",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "Marketing",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        ]);
    }
}