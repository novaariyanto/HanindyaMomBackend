<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            if (!Auth::user()->hasRole('admin')) {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun ini bukan admin.']);
            }
            return redirect()->intended('/admin');
        }

        // Fallback login by email
        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            if (!Auth::user()->hasRole('admin')) {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun ini bukan admin.']);
            }
            return redirect()->intended('/admin');
        }

        return back()->withErrors(['username' => 'Kredensial tidak valid.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}


