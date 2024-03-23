<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\Subcriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Employee::query();

        if ($user->role != User::ADMIN) {
            $query->where('assessor_id', $user->id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $employees = $query->paginate(10);

        return view('pages.assessment.index', compact('employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($employeeId)
    {
        $employee         = Employee::findOrFail($employeeId);
        $criterias        = Criteria::all();

        $assessments = [];
        foreach ($criterias as $criteria) {
            $assessmentModels = Assessment::with('subcriteria')
                ->where('employee_id', $employeeId)
                ->where('criteria_id', $criteria->id)
                ->orderBy('subcriteria_id', 'asc')
                ->get();

            $assessmentResponse = [];
            foreach ($assessmentModels as $assessment) {
                $assessmentResponse[] = (object)[
                    'id'    => $assessment->id,
                    'name'  => $assessment->subcriteria['name'],
                    'value' => $assessment->value,
                ];
            }
            $assessments[] = (object) ['criteria' => $criteria->name, 'values' => $assessmentResponse];
        }

        $grade_dropdown = Assessment::gradeDropdown();
        return view('pages.assessment.edit', compact('employee', 'assessments', 'grade_dropdown'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        foreach ($request->all() as $key => $value) {
            Assessment::where('id', intval($key))->update(['value' => $value]);
        }

        toast('Nilai berhasil diupdate', 'success');
        return redirect()->route('assessment');
    }


    public function matrix()
    {
        $employees       = Employee::all();
        $subcriteriaList = Subcriteria::all();
        $assessments     = Assessment::with('subcriteria', 'employee')->get();

        return view('pages.assessment.result', compact('employees', 'subcriteriaList', 'assessments'));
    }

    public function calculate()
    {
        if (!Criteria::isCRValid() || !Criteria::isMatrixValid()) {
            toast('Nilai CR kriteria tidak valid', 'error');
            return redirect()->back();
        }

        $criterias = Criteria::all();
        foreach ($criterias as $criteria) {
            if (!Subcriteria::isCRValid($criteria->id) || !Subcriteria::isMatrixValid($criteria->id)) {
                toast('Nilai CR subkriteria (' . $criteria->name . ') tidak valid', 'error');
                return redirect()->back();
            }
        }

        Assessment::calculate();

        toast('Berhasil hitung nilai', "success");
        return redirect()->back();
    }

    public function create()
    {
        $employees = Employee::all();
        $criterias = Criteria::with('subcriteria')->get();

        return view('pages.assessment.create', compact('employees', 'criterias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'criteria.*.subcriteria.*.value' => 'required|integer|min:1|max:4',
            'criteria.*.subcriteria.*.subcriteria_id' => [
                Rule::unique('assessments', 'subcriteria_id')->where(function ($query) use ($request) {
                    return $query->where('employee_id', $request->employee_id);
                })
            ],
        ]);

        $assessments = [];
        foreach ($data['criteria'] as $criteriaId => $subcriteria) {
            foreach ($subcriteria['subcriteria'] as $subcriteriaId => $value) {
                $exists = Assessment::where([
                    'employee_id' => $request->employee_id,
                    'criteria_id' => $criteriaId,
                    'subcriteria_id' => $subcriteriaId,
                ])->exists();

                if (!$exists) {
                    $assessments[] = [
                        'employee_id' => $request->employee_id,
                        'criteria_id' => $criteriaId,
                        'subcriteria_id' => $subcriteriaId,
                        'value' => $value['value'],
                        'normalization_value' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($assessments)) {
            Assessment::insert($assessments);
            toast('Data berhasil disimpan', 'success');
        } else {
            toast('Data sudah ada, tidak perlu disimpan', 'warning');
        }

        return redirect()->route('assessment');
    }

}