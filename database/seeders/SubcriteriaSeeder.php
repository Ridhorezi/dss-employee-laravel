<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SubcriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("subcriterias")->insert([
            [
                "name"        => "Kedisiplinan",
                "criteria_id" => 1,
                "order" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Tanggung Jawab",
                "criteria_id" => 1,
                "order" => 2,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Komunikasi",
                "criteria_id" => 1,
                "order" => 3,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Antusiasme",
                "criteria_id" => 1,
                "order" => 4,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Pengetahuan &  Kemampuan Teknis",
                "criteria_id" => 2,
                "order" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Efesiensi & Efektifitas",
                "criteria_id" => 2,
                "order" => 2,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Kerjasama",
                "criteria_id" => 2,
                "order" => 3,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Tindak lanjut pendelegasian",
                "criteria_id" => 2,
                "order" => 4,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Pelaksanaan Tugas khusus",
                "criteria_id" => 2,
                "order" => 5,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Pengaturan Waktu kerja",
                "criteria_id" => 3,
                "order" => 1,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Kreatifitas",
                "criteria_id" => 3,
                "order" => 2,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Pencatatan, Penyimpanan, Pelaporan",
                "criteria_id" => 3,
                "order" => 3,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Pengelolaan Alat & Lingkungan Kerja",
                "criteria_id" => 3,
                "order" => 4,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
            [
                "name"        => "Kemampuan Persuasif",
                "criteria_id" => 3,
                "order" => 5,
                "created_at"  => Carbon::now(),
                "updated_at"  => Carbon::now()
            ],
        ]);
    }
}
