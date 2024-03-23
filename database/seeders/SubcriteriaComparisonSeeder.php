<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\Subcriteria;
use App\Models\SubcriteriaComparison;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcriteriaComparisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = Criteria::all();

        $excludedIds = [];
        foreach ($criterias as $criteria) {
            $subcriterias = Subcriteria::where('criteria_id', $criteria->id)->get();
            $count = $subcriterias->count();

            $row = 1;
            foreach ($subcriterias as $subcriteria) {
                for ($column = 1; $column <= $count; $column++) {
                    $criteriaComparison = SubcriteriaComparison::updateOrCreate(
                        [
                            'subcriteria_id' => $subcriteria->id ,
                            'row_idx'        => $row ,
                            'column_idx'     => $column,
                            'value'          => $row == $column ? 1 : 0
                        ],
                        []
                    );

                    $excludedIds[] = $criteriaComparison->id;
                }
                $row++;
            }
        }
        SubcriteriaComparison::whereNotIn('id', $excludedIds)->delete();
    }
}
