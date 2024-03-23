<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
        }

        $originalData = $query->paginate(10);

        $users = [];

        foreach ($originalData as $user) {
            $users[] = (object) [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ];
        }

        return view('pages.user.index')
            ->with("users", $users)
            ->with("originalData", $originalData)
            ->render();
    }

    public function create()
    {
        return response(['roleDropdown' => User::roleDropdown()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required',
            'password' => 'required',
            'role'     => 'required',
        ]);

        $user           = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = $request->password;
        $user->role     = $request->role;
        $user->save();

        toast('Berhasil tambah user', 'success');
        return redirect()->route('user')->with('success', 'Berhasil menambahkan user');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response([
            'user'         => $user,
            'roleDropdown' => User::roleDropdown()
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required',
            'role'     => 'required',
        ]);

        $user           = User::findOrFail($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = $request->password != null ? Hash::make($request->password) : $user->password;
        $user->role     = $request->role;
        $user->save();

        toast('Berhasil ubah user', 'success');
        return redirect()->route('user')->with('success', 'Berhasil mengubah user');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->route('user')->with('error', 'Gagal menghapus user');
        }
        $user->delete();

        toast('Berhasil hapus user', 'success');
        return redirect()->route('user')->with('success', 'Berhasil menghapus user');
    }
}