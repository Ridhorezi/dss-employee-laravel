<?php

namespace App\Models;

use App\Http\helpers\Formula;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subcriteria extends Model
{
    use HasFactory;

    public function kriteria(): HasOne
    {
        return $this->hasOne(Criteria::class, 'id', 'criteria_id');
    }

    public function perhitungansubkriterias(): HasMany
    {
        return $this->hasMany(SubcriteriaCalculation::class, 'subcriteria_id', 'id');
    }

    /**
     * Get all of the comparisons for the Subcriteria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comparisons(): HasMany
    {
        return $this->hasMany(SubcriteriaComparison::class, 'subcriteria_id');
    }

    /**
     * Get all of the assessments for the Subcriteria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'subcriteria_id');
    }

    public static function getMaxLamda($criteriaId)
    {
        return self::where('criteria_id', $criteriaId)->sum('eigen');
    }

    public static function getCI($criteriaId)
    {
        $count = Subcriteria::where('criteria_id', $criteriaId)->count();
        return number_format((self::getMaxLamda($criteriaId) - $count) / ($count - 1), 2);
    }
    public static function getCR($criteriaId)
    {
        $count = Subcriteria::where('criteria_id', $criteriaId)->count();
        return number_format((self::getCI($criteriaId) / Formula::$nilai_index_random[$count]), 2);
    }

    public static function isCRValid($criteriaId)
    {
        return self::getCR($criteriaId) <= 0.1;
    }

    public static function isMatrixValid($criteriaId)
    {
        $matrixZeroValueExists = SubcriteriaComparison::whereHas('subcriteria', function ($query) use ($criteriaId) {
            $query->where('criteria_id', $criteriaId);
        })->where('value', 0)->exists();
        return !$matrixZeroValueExists;
    }

    public static function updateSubcriteriaOrder()
    {
        $criterias = Criteria::all();
        foreach ($criterias as $criteria) {
            $subcriterias = Subcriteria::where('criteria_id', $criteria->id)->get();
            $subcriteriaCount = $subcriterias->count();
            $subcriteriaOrderInvalid = Subcriteria::where('criteria_id', $criteria->id)->where('order', '>', $subcriteriaCount)->first();
            if ($subcriteriaOrderInvalid == null) {
                return;
            }

            $order = 1;
            foreach ($subcriterias as $subcriteria) {
                $subcriteria->order = $order;
                $subcriteria->save();

                $subcriteria->load(['comparisons' => function ($query) {
                    $query->orderBy('column_idx', 'asc');
                }]);

                $column = 1;
                foreach ($subcriteria->comparisons as $comparison) {
                    $comparison->row_idx = $order;
                    $comparison->column_idx = $column;
                    $comparison->save();
                    $column++;
                }

                $order++;
            }
        }
    }
}
