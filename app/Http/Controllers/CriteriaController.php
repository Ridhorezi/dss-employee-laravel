<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\CriteriaComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Criteria::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $criterias = $query->paginate(10);

        return view('pages.criteria.index', ['criterias' => $criterias])->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = preg_replace('/\s+/', ' ', $request->name);
        if (Criteria::where('name', $name)->count() > 0) {
            toast('Nama kriteria sudah ada', 'error');
            return redirect()->route('criteria');
        }
        DB::transaction(function () use ($name) {
            $kriteriaModel = new Criteria();
            $kriteriaModel->name = $name;
            $kriteriaModel->order = Criteria::count() + 1;
            $kriteriaModel->save();

            $this->runCriteriaComparisonSeeder();
        }, 3);

        toast('Berhasil menambahkan kriteria', 'success');
        return redirect()->route('criteria');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $criteria = Criteria::findOrFail($id);
        return response($criteria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $criteria = Criteria::findOrFail($id);

        $name = preg_replace('/\s+/', ' ', $request->name);
        if (Criteria::where('name', $name)->where('id', '!=', $id)->count() > 0) {
            toast('Nama kriteria sudah ada', 'error');
            return redirect()->route('criteria');
        }

        $criteria->name = $name;
        $criteria->save();
        toast('Berhasil edit kriteria', 'success');
        return redirect()->route('criteria');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $criteria = Criteria::findOrFail($id);
        DB::transaction(function () use ($criteria) {
            $criteria->delete();

            CriteriaComparison::where('column_idx', $criteria->order)->delete();
            Criteria::updateCriteriaOrder();
            CriteriaComparison::calculateMatrix();
        });
        toast('Berhasil menghapus kriteria', 'success');
        return redirect()->route('criteria');
    }

    public function runCriteriaComparisonSeeder()
    {
        Artisan::call('db:seed', [
            '--class' => 'CriteriaComparisonSeeder',
            '--force' => true, // Use this flag to force the seeder to run in production
        ]);
    }
}