<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CriteriaComparison extends Model
{
    use HasFactory;

    /**
     * Get the criteria that owns the CriteriaComparison
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }

    public static function calculateMatrix()
    {
        // Hitung comparison column sum
        $sumColumns = CriteriaComparison::groupBy('column_idx')
            ->selectRaw('column_idx, SUM(value) as total')
            ->get();
        foreach ($sumColumns as $sumColumn) {
            Criteria::where('order', $sumColumn->column_idx)->update(['comparison_column_sum' => $sumColumn->total]);
        }

        // Update normalization value
        // normalization_value = cell/sum kolom comparison
        $criteriaComparisons = CriteriaComparison::all();
        foreach ($criteriaComparisons as $criteriaComparison) {
            $criteriaComparison->normalization_value = ($criteriaComparison->value /
                Criteria::where('order', $criteriaComparison->column_idx)->value('comparison_column_sum')
            );
            $criteriaComparison->save();
        }

        // Hitung normalization row sum
        $sumRows = CriteriaComparison::groupBy('row_idx')
            ->selectRaw('row_idx, SUM(normalization_value) as total')
            ->get();
        foreach ($sumRows as $sumRow) {
            Criteria::where('order', $sumRow->row_idx)->update(['normalization_row_sum' => $sumRow->total]);
        }

        // Hitung priority & eigen
        $criterias = Criteria::all();
        $criteriasCount = $criterias->count();
        foreach ($criterias as $criteria) {
            $criteria->priority = $criteria->normalization_row_sum / $criteriasCount;
            $criteria->eigen = $criteria->priority * $criteria->comparison_column_sum;
            $criteria->save();
        }
    }
}
