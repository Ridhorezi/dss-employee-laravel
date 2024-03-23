<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubcriteriaComparison extends Model
{
    use HasFactory;

    /**
     * Get the subcriteria that owns the SubcriteriaComparison
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcriteria(): BelongsTo
    {
        return $this->belongsTo(Subcriteria::class, 'subcriteria_id');
    }

    public static function calculateMatrix($criteria_id) {

        $subcriteriaComparisons = SubcriteriaComparison::whereHas('subcriteria', function ($query) use ($criteria_id) {
            $query->where('criteria_id', $criteria_id);
        })->get();
        
        // Hitung comparison column sum
        $sumColumns = SubcriteriaComparison::whereHas('subcriteria', function ($query) use ($criteria_id) {
            $query->where('criteria_id', $criteria_id);
        })
            ->groupBy('column_idx')
            ->selectRaw('column_idx, SUM(value) as total')
            ->get();
        foreach ($sumColumns as $sumColumn) {
            Subcriteria::where('criteria_id', $criteria_id)->where('order', $sumColumn->column_idx)->update(['comparison_column_sum' => $sumColumn->total]);
        }

        // Update normalization value
        // normalization_value = cell/sum kolom comparison
        foreach ($subcriteriaComparisons as $criteriaComparison) {
            $criteriaComparison->normalization_value = ($criteriaComparison->value /
                Subcriteria::where('criteria_id', $criteria_id)->where('order', $criteriaComparison->column_idx)->value('comparison_column_sum')
            );
            $criteriaComparison->save();
        }

        // Hitung normalization row sum
        $sumRows = SubcriteriaComparison::whereHas('subcriteria', function ($query) use ($criteria_id) {
            $query->where('criteria_id', $criteria_id);
        })
            ->groupBy('row_idx')
            ->selectRaw('row_idx, SUM(normalization_value) as total')
            ->get();
        foreach ($sumRows as $sumRow) {
            Subcriteria::where('order', $sumRow->row_idx)->update(['normalization_row_sum' => $sumRow->total]);
        }

        // Hitung priority & eigen
        $subcriterias = Subcriteria::where('criteria_id', $criteria_id)->get();
        $criteriasCount = $subcriterias->count();
        foreach ($subcriterias as $subcriteria) {
            $subcriteria->priority = $subcriteria->normalization_row_sum / $criteriasCount;
            $subcriteria->eigen = $subcriteria->priority * $subcriteria->comparison_column_sum;
            $subcriteria->save();
        }
    }
}
