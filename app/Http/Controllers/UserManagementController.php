<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('nama_lengkap')->get();
        $roles = Role::all();

        return view('owner.akun.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'role_id' => 'required',
            'password' => 'required|min:4',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'password' => hash('sha256', $request->password),
            'status' => 'aktif',
            'dibuat_pada' => now('Asia/Jakarta'),
        ]);

        return back()->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama_lengkap' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ];

        if ($request->username !== $user->username) {
            $rules['username'] = 'required|unique:users';
        }

        if ($request->password != '') {
            $rules['password'] = 'min:4';
        }

        $request->validate($rules);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        if ($request->password != "") {
            $user->password = hash('sha256', $request->password);
        }

        $user->save();

        return back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }
}
