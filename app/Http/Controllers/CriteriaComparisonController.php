<?php

namespace App\Http\Controllers;

use App\Http\helpers\Formula;
use App\Models\Criteria;
use App\Models\CriteriaComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CriteriaComparisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criterias      = Criteria::with('comparisons')->get();
        $count_criteria = $criterias->count();
        $is_valid       = Criteria::isCRValid();
        $IR             = Formula::$nilai_index_random[$count_criteria];
        $CI             = Criteria::getCI();
        $max_lamda      = Criteria::getMaxLamda();
        $CR             = Criteria::getCR();
        $matrix_valid   = Criteria::isMatrixValid();

        return view('pages.criteria.matrix', compact(
            'criterias',
            'is_valid',
            'IR',
            'CI',
            'CR',
            'max_lamda',
            'count_criteria',
            'matrix_valid'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Simpan criteria comparison
            $criteriaComparisons = CriteriaComparison::all();
            foreach ($criteriaComparisons as $criteriaComparison) {
                $criteriaComparison->value = $request->post(strval($criteriaComparison->id));
                $criteriaComparison->save();
            }
            CriteriaComparison::calculateMatrix();
        }, env("DB_RETRY", 3));

        $redirect = route('criteria.matrix');
        return response()->json(['redirect' => $redirect]);
    }

    public function hasil()
    {
        $criterias = Criteria::with('comparisons')->get();
        $count_criteria = $criterias->count();
        $is_valid  = Criteria::isCRValid();
        $IR = Formula::$nilai_index_random[$count_criteria];
        $CI = Criteria::getCI();
        $max_lamda = Criteria::getMaxLamda();

        return view('pages.criteria.matrix', compact(
            'criterias',
            'is_valid',
            'IR',
            'CI',
            'max_lamda',
            'count_criteria'
        ));
    }
}