<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;

class AlternatifDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        if($id == null) {
            return redirect('employee');
        }
        $details = EmployeeDetail::where('employee_id', $id)
        ->get();
        $kriterias = Criteria::get();
        return view('pages.alternatif_detail/index', ['details' => $details, 'kriterias' => $kriterias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->post('list_subkriteria')) {
            return redirect('/employee_detail?id=' . $request->id_employee)->with('error', 'Gagagl menambahkan detail');
        }
        $employee_id = $request->post('employee_id');
        $kriteria_id = $request->post('kriteria_id');
        if($request->post('list_subkriteria')) {
            foreach($request->post('list_subkriteria') as $index => $subkriteria) {
                $employee_detail = EmployeeDetail::where('employee_id', $employee_id)->where('criteria_id', $kriteria_id[$index])->first();
                if(!$employee_detail) {
                    $employee_detail = new EmployeeDetail();
                    $employee_detail->employee_id = $employee_id;
                    $employee_detail->criteria_id = $kriteria_id[$index];
                }
                $employee_detail->subcriteria_id = $subkriteria;
                $employee_detail->save();
            }
            return redirect('/employee_detail?id=' . $employee_id)->with('success', 'Berhasil menambahkan detail');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeDetail $alternatifDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeDetail $alternatifDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeDetail $alternatifDetail)
    {
        $id = $request->input('id_alternatifDetails');
        $alternatifDetail = EmployeeDetail::where('id', $id)->first();
        $alternatifDetail->nama_AlternatifDetail = $request->input('nama_alternatifDetails');
        $criteria_id = $alternatifDetail->criteria_id;
        $alternatifDetail->save();
        return redirect('/employee_detail?id=' . $criteria_id)->with('success', 'Berhasil edit detail');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id_alternatifDetails');
        $alternatifDetail = EmployeeDetail::where('id', $id)->first();
        $criteria_id = $alternatifDetail->criteria_id;
        $alternatifDetail->delete();
        return redirect('/employee_detail?id=' . $criteria_id)->with('success', 'Berhasil menghapus EmployeeDetail');
    }
}