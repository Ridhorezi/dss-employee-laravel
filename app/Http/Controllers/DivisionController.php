<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Alert;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $query = Division::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $originalData = $query->paginate(10);

        $divisions = [];

        foreach ($originalData as $division) {
            $divisions[] = (object) [
                'id'          => $division->id,
                'name'        => $division->name,
            ];
        }

        return view('pages.division.index')
            ->with("divisions", $divisions)
            ->with("originalData", $originalData)->render();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string'
        ]);

        $division            = new Division();
        $division->name      = $request->name;
        $division->save();

        toast('Berhasil menambahkan Divisi', 'success');
        return back();
    }

    public function edit($id)
    {
        $divisionModel = Division::find($id);
        if ($divisionModel == null) {
            return response("Data tidak ditemukan.", Response::HTTP_NOT_FOUND);
        }
        $division = (object) [
            'id'          => $divisionModel->id,
            'name'        => $divisionModel->name,
        ];

        return response([
            "division" => $division
        ]);
    }

    public function update($id, Request $request)
    {
        $division = Division::find($id);

        if ($division == null) {
            return response("Data tidak ditemukan.", Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name'      => 'required|string',
        ]);

        $division->name      = $request->name;
        $division->save();

        toast('Berhasil mengubah Divisi', 'success');
        return back();
    }

    public function destroy($id)
    {
        $division = Division::find($id);

        if ($division == null) {
            toast("Data tidak ditemukan.", "error");
            return back();
        }
        $division->delete();

        toast('Berhasil menghapus Divisi', 'success');
        return back();
    }

    public function dropdownParentCreate($level)
    {
        return response(self::getDropdownParentByLevel($level));
    }

    public function dropdownParentUpdate($id, $level)
    {
        return response(self::getDropdownParentByIdAndLevel($id, $level));
    }

    private static function getDropdownParentByIdAndLevel($id, $level = null)
    {
        $parents = [];
        if ($level > 1) {
            $divisions = Division::where('id', '!=', $id)->where('level', '<', $level)->get();
            foreach ($divisions as $division) {
                $parents[] = [
                    'value' => $division->id,
                    'label' => $division->name
                ];
            }
        } else {
            $parents[] = [
                'value' => 0,
                'label' => 'Sebagai Parent Utama'
            ];
        }

        return $parents;
    }

    private static function getDropdownParentByLevel($level = null)
    {
        $parents = [];
        if ($level > 1) {
            $divisions = Division::where('level', '<', $level)->get();
            foreach ($divisions as $division) {
                $parents[] = [
                    'value' => $division->id,
                    'label' => $division->name
                ];
            }
        } else {
            $parents[] = [
                'value' => 0,
                'label' => 'Sebagai Parent Utama'
            ];
        }

        return $parents;
    }
}