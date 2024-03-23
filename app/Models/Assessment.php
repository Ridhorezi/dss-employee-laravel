<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Assessment extends Model
{
    use HasFactory;

    public const KURANG_BAIK = 1;
    public const CUKUP_BAIK  = 2;
    public const BAIK        = 3;
    public const SANGAT_BAIK = 4;


    /**
     * Get the employee that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the subcriteria that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcriteria(): BelongsTo
    {
        return $this->belongsTo(Subcriteria::class, 'subcriteria_id');
    }

    /**
     * Get the criteria that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    public static function grade()
    {
        return [
            self::KURANG_BAIK => 'Kurang Baik',
            self::CUKUP_BAIK  => 'Cukup Baik',
            self::BAIK        => 'Baik',
            self::SANGAT_BAIK => 'Sangat Baik',
        ];
    }

    public static function gradeDropdown()
    {
        $dropdown = [];
        foreach (self::grade() as $key => $value) {
            $dropdown[] = (object) [
                'value' => $key,
                'label' => $value
            ];
        }
        return $dropdown;
    }

    public function getGradeString()
    {
        return $this->roleUser()[$this->value];
    }

    public static function generateAssessmentNewEmployee(Employee $employee)
    {
        $subcriterias = Subcriteria::all();
        foreach ($subcriterias as $subcriteria) {
            $assessment = new Assessment();
            $assessment->employee_id = $employee->id;
            $assessment->criteria_id = $subcriteria->criteria_id;
            $assessment->subcriteria_id = $subcriteria->id;
            $assessment->save();
        }
    }

    public static function generateAssessmentNewSubcriteria(Subcriteria $subcriteria)
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $assessment = new Assessment();
            $assessment->employee_id = $employee->id;
            $assessment->criteria_id = $subcriteria->criteria_id;
            $assessment->subcriteria_id = $subcriteria->id;
            $assessment->save();
        }
    }

    public static function calculate()
    {
        DB::transaction(function () {
            $subcriterias = Subcriteria::all();

            foreach ($subcriterias as $subcriteria) {
                $subcriteria->alternative_column_sum = Assessment::where('subcriteria_id', $subcriteria->id)
                    ->selectRaw('SUM(value) as value')
                    ->groupBy('subcriteria_id')
                    ->value('value');
                $subcriteria->save();

                $subcriteria->load('assessments');
                foreach ($subcriteria->assessments as $assessment) {
                    $assessment->normalization_value =
                        $subcriteria->alternative_column_sum > 0 ? ($assessment->value / $subcriteria->alternative_column_sum) : 0;
                    $assessment->save();
                }
            }

            $employees = Employee::all();
            foreach ($employees as $employee) {
                $employee->load('assessments');
                $employeeResultValue = 0;
                foreach ($employee->assessments as $assessment) {
                    $assessment->load(['subcriteria', 'criteria']);
                    $employeeResultValue += ($assessment->normalization_value * $assessment->subcriteria->priority * $assessment->criteria->priority);
                    $employee->save();
                }
                $employee->value = $employeeResultValue;
                $employee->save();
            }

            // Ambil data employee yang sudah diurutkan berdasarkan nilai value dari yang terbesar
            $employees = Employee::orderByDesc('value')->get();

            // Lakukan update kolom rangking berdasarkan urutan data yang sudah diurutkan
            foreach ($employees as $index => $employee) {
                $employee->rangking = ($index + 1);
                $employee->save();
            }
        });
    }
}
