<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public $defaultLevel = [];
    public $defaultDivision = [];
    public $defaultHead = [];
    public $defaultAssessor = [];

    function __construct()
    {
        $this->defaultLevel[]    = (object) ['value' => 0, 'label' => 'Pilih Level'];
        $this->defaultDivision[] = (object) ['value' => 0, 'label' => 'Pilih Divisi'];
        $this->defaultHead[]     = (object) ['value' => 0, 'label' => 'Pilih Kepala'];
        $this->defaultAssessor[] = (object) ['value' => 0, 'label' => 'Pilih Penilai'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $originalData = $query->paginate(10);

        $employees = [];

        foreach ($originalData as $employee) {
            $employees[] = (object) [
                'id'       => $employee->id,
                'ein'      => $employee->ein,
                'name'     => $employee->name,
                'division' => $employee->division['name'],
                'assessor' => $employee->assessor['name']
            ];
        }
        return view('pages.employee.index')
            ->with('employees', $employees)
            ->with('originalData', $originalData)->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        $divisionsDropdown = [];
        foreach ($divisions as $division) {
            $divisionsDropdown[] = (object) [
                'value' => $division->id,
                'label' => $division->name
            ];
        }

        $assessors = User::where('role', User::ASSESSOR)->get();
        $assessorDropdown = [];
        foreach ($assessors as $assessor) {
            $assessorDropdown[] = (object) [
                'value' => $assessor->id,
                'label' => $assessor->name
            ];
        }
        return response([
            'divisionsDropdown' => array_merge($this->defaultDivision, $divisionsDropdown),
            'assessorDropdown' => array_merge($this->defaultAssessor, $assessorDropdown),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'ein'         => 'required',
            'division_id' => 'required',
            'assessor_id' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $employee              = new Employee();
            $employee->name        = $request->name;
            $employee->ein         = $request->ein;
            $employee->division_id = $request->division_id;
            $employee->assessor_id = $request->assessor_id;
            $employee->save();

            Assessment::generateAssessmentNewEmployee($employee);
        });

        toast('Berhasil menambahkan pegawai', 'success');
        return redirect()->route('employee')->with('success', 'Berhasil menambahkan employee');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employeeModel = Employee::findOrFail($id);
        if ($employeeModel == null) {
            return response("Data tidak ditemukan.", Response::HTTP_NOT_FOUND);
        }
        $employee = (object) [
            'id'          => $employeeModel->id,
            'ein'         => $employeeModel->ein,
            'name'        => $employeeModel->name,
            'division_id' => $employeeModel->division_id,
            'assessor_id' => $employeeModel->assessor_id,
        ];

        $divisions = Division::all();
        $divisionsDropdown = [];
        foreach ($divisions as $division) {
            $divisionsDropdown[] = (object) [
                'value' => $division->id,
                'label' => $division->name
            ];
        }

        $assessors = User::where('role', User::ASSESSOR)->get();
        $assessorDropdown = [];
        foreach ($assessors as $assessor) {
            $assessorDropdown[] = (object) [
                'value' => $assessor->id,
                'label' => $assessor->name
            ];
        }

        return response([
            "employee"          => $employee,
            "divisionsDropdown" => array_merge($this->defaultDivision, $divisionsDropdown),
            'assessorDropdown'  => array_merge($this->defaultAssessor, $assessorDropdown),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required',
            'division_id' => 'required',
            'assessor_id' => 'required',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->name        = $request->name;
        $employee->division_id = $request->division_id;
        $employee->assessor_id = $request->assessor_id;
        $employee->save();

        toast('Berhasil edit pegawai', 'success');
        return redirect()->route('employee')->with('success', 'Berhasil edit employee');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id_employee');
        $employee = Employee::where('id', $id)->first();
        if (!$employee) {
            toast('Data tidak ditemukan', 'error');
            return redirect()->route('employee')->with('error', 'Gagal menghapus employee');
        }
        $employee->delete();
        toast('Berhasil hapus pegawai', 'success');
        return redirect()->route('employee')->with('success', 'Berhasil menghapus employee');
    }

    public function dropdownHeadByDivisi($divisionId)
    {
        $heads = [];

        $division = Division::find($divisionId);
        if ($division != null) {
            $employees = Employee::with(['division' => function ($query) use ($division) {
                $query->where('divisions.level', '<=', $division->level);
            }])
                ->where('level', '<', Employee::STAF)
                ->get();

            foreach ($employees as $employee) {
                $heads[] = [
                    'value' => $employee->id,
                    'label' => $employee->name
                ];
            }
        }

        return response(array_merge($this->defaultHead, $heads));
    }

    public function suggestPosisi(Request $request)
    {
        $keyword = $request->input('keyword');

        $suggestions = Position::where('name', 'like', '%' . $keyword . '%')->pluck('name');

        return response()->json($suggestions);
    }

    public static function generateEmployeeNumber($carbonDate)
    {
        $year = $carbonDate->year;
        $month = $carbonDate->month;

        $employeeLatest = Employee::whereYear('joined', $year)
            ->whereMonth('joined', $month)
            ->latest()
            ->first();
        $number = ($employeeLatest == null ? 0 : intval(substr($employeeLatest, -2))) + 1;

        $employeeId = sprintf(Employee::FORMAT_EMPLOYEE_ID, intval($year % 100), intval($month), $number);
        return $employeeId;
    }
}