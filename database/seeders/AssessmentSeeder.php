<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Subcriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $subcriterias = Subcriteria::all();

        foreach ($employees as $employee) {
            foreach ($subcriterias as $subcriteria) {
                $assessment = new Assessment();
                $assessment->employee_id = $employee->id;
                $assessment->criteria_id = $subcriteria->criteria_id;
                $assessment->subcriteria_id = $subcriteria->id;
                $assessment->save();
            }
        }

        $filePath = base_path("database/data/assessments.xlsx");

        // Membaca file XLSX
        $data = Excel::toCollection(null, $filePath, null, null, [
            'startRow' => 2,
            'startColumn' => 1,
        ])->first();

        // Loop melalui setiap baris data
        foreach ($data as $row) {
            $countColumn = count($row);
            $ein = str_pad($row['0'], 6, '0', STR_PAD_LEFT);
            $employee = Employee::where('ein', $ein)->first();
            if ($employee) {
                for ($i = 1; $i < $countColumn; $i++) {
                    $subcriteria = Subcriteria::find($i);
                    if ($subcriteria) {
                        DB::table('assessments')->updateOrInsert(
                            [
                                "employee_id"    => $employee->id,
                                "criteria_id"    => $subcriteria->criteria_id,
                                "subcriteria_id" => $subcriteria->id,
                            ],
                            [
                                "value" => substr("`" . $row[strval($i)], -1)
                            ]
                        );
                    }
                }
            }
        }
    }
}
