<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Criteria;
use App\Models\Subcriteria;
use App\Models\SubcriteriaComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SubcriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $query = Subcriteria::where('criteria_id', $id);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $subcriterias = $query->paginate(10);

        return view('pages.subcriteria.index', [
            'criteria_id'  => $id,
            'subcriterias' => $subcriterias
        ])->render();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = preg_replace('/\s+/', ' ', $request->name);
        if (Subcriteria::where('name', $name)->count() > 0) {
            return redirect()->route('subcriteria', ['criteriaId' => $request->criteria_id])->with("error", "Nama subkriteria sudah ada");
        }

        DB::transaction(function () use ($name, $request) {
            $subcriteria = new Subcriteria();
            $subcriteria->name = $name;
            $subcriteria->criteria_id = $request->criteria_id;
            $subcriteria->order = Subcriteria::where('criteria_id', $request->criteria_id)->count() + 1;
            $subcriteria->save();

            Assessment::generateAssessmentNewSubcriteria($subcriteria);
            $this->runSubcriteriaComparisonSeeder();
        });

        toast('Berhasil tambah subkriteria', 'success');
        return redirect()->route('subcriteria', ['criteriaId' => $request->criteria_id])->with('success', 'Berhasil menambahkan subkriteria');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subcriteria = Subcriteria::findOrFail($id);
        return response($subcriteria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subcriteria = Subcriteria::findOrFail($id);

        $name = preg_replace('/\s+/', ' ', $request->name);
        if (Subcriteria::where('name', $name)->where('id', '!=', $id)->count() > 0) {
            return redirect()->route('subcriteria', ['criteriaId' => $request->criteria_id])->with("error", "Nama subkriteria sudah ada");
        }

        $subcriteria->name = $name;
        $subcriteria->save();

        $criteria_id = $subcriteria->criteria_id;
        toast('Berhasil ubah subkriteria', 'success');
        return redirect()->route('subcriteria', ['criteriaId' => $criteria_id])->with('success', 'Berhasil edit subkriteria');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcriteria = Subcriteria::findOrFail($id);
        $criteria_id = $subcriteria->criteria_id;

        DB::transaction(function () use ($subcriteria) {
            $subcriteria->delete();
            SubcriteriaComparison::where('column_idx', $subcriteria->order)->delete();
            Subcriteria::updateSubcriteriaOrder();
            SubcriteriaComparison::calculateMatrix($subcriteria->criteria_id);
        }, 3);
        toast('Berhasil hapus subkriteria', 'success');
        return redirect()->route('subcriteria', ['criteriaId' => $criteria_id])->with('success', 'Berhasil menghapus subkriteria');
    }

    public function runSubcriteriaComparisonSeeder()
    {
        Artisan::call('db:seed', [
            '--class' => 'SubcriteriaComparisonSeeder',
            '--force' => true, // Use this flag to force the seeder to run in production
        ]);
    }
}