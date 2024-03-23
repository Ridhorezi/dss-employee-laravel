<?php

namespace Database\Seeders;

use App\Models\Criteria;
use App\Models\CriteriaComparison;
use Illuminate\Database\Seeder;

class CriteriaComparisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = Criteria::all();

        $count = count($criterias);

        $row = 1;

        $excludedIds = [];

        foreach ($criterias as $criteria) {
            for ($column = 1; $column <= $count; $column++) {
                $criteriaComparison = CriteriaComparison::updateOrCreate(
                    [
                        'criteria_id' => $criteria->id,
                        'row_idx'     => $row,
                        'column_idx'  => $column,
                        'value'       => $row == $column ? 1 : 0
                    ],
                    []
                );

                $excludedIds[] = $criteriaComparison->id;
            }
            $row++;
        }

        CriteriaComparison::whereNotIn('id', $excludedIds)->delete();
    }
}