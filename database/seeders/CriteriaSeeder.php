<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("criterias")->insert([
            [
                "name"       => "KEPRIBADIAN DAN PERILAKU",
                "order"      => 1,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "PRESTASI DAN HASIL KERJA",
                "order"      => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "name"       => "PROSES KERJA",
                "order"      => 3,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]
        ]);
    }
}
