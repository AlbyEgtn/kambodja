<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|not_regex:/<[^>]*>/',
            'password' => 'required|string|max:255'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username tidak ditemukan']);
        }

        // Hash SHA-256 sesuai permintaan Anda
        $password = hash('sha256', $request->password);

        if ($password !== $user->password) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        if ($user->status !== 'aktif') {
            return back()->withErrors(['status' => 'Akun tidak aktif']);
        }

        auth()->login($user);

        // Redirect berdasarkan role
        $role = $user->role->nama;

        if ($role === 'Karyawan') return redirect()->route('karyawan.dashboard');
        if ($role === 'Kasir') return redirect()->route('kasir.dashboard');
        if ($role === 'Owner') return redirect()->route('owner.dashboard');

        return redirect('/login')->withErrors(['role' => 'Role tidak dikenali']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
