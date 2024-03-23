<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $csvFile = fopen(base_path("database/data/employee_sample_data.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Employee::create([
                    "ein"         => $data[0],
                    "name"        => $data[1],
                    "division_id" => $data[2],
                    "assessor_id" => $data[3],
                    "gender"      => $data[4],
                    "age"         => $data[5],
                    "country"     => $data[6],
                    "city"        => $data[7],
                    "anual_salary"=> $data[8],
                    "job_title"   => $data[9],
                    "created_at"  => Carbon::now(),
                    "updated_at"  => Carbon::now(),
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}