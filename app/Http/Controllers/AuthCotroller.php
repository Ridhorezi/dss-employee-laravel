<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCotroller extends Controller
{
    public function login()
    {
        if (Auth::user()) {
            return redirect()->route('home');
        }
        return view('pages.auth.login');
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Authentication successful
            toast("Login berhasil", "success");
            return redirect()->route('dashboard');
        } else {
            // Authentication failed
            toast("Email atau password salah", "error");
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast('Logout berhasil', 'success');
        return redirect()->route('login');
    }
}