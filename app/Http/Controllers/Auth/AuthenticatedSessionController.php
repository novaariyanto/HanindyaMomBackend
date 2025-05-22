<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\OTPVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // exit;
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

     public function store(LoginRequest $request)
     {
         // Ambil input username dan password
         $username = $request->input('username');
         $password = $request->input('password');
     
         // Cek apakah password adalah 6 digit angka (OTP)
         if (preg_match('/^\d{6}$/', $password)) {
             // Jika password adalah OTP, cek validasi OTP
             $otpVerification = OTPVerification::where('nomor_hp', $username)->first();
            
            //  return $otpVerification;
             if (!$otpVerification || !$otpVerification->isValidOTP($password)) {
                 return back()->withErrors([
                     'password' => 'Kode OTP tidak valid atau telah kedaluwarsa.',
                 ])->withInput();
             }
     
             // Jika OTP valid, autentikasi pengguna
             $user = $otpVerification->user;
            //  return $user;
             Auth::login($user);
     

             $otpVerification->delete();

             // Regenerate session untuk keamanan
             $request->session()->regenerate();
     
             return redirect()->intended(route('dashboard', absolute: false));
         } else {
             // Jika password bukan OTP, gunakan autentikasi biasa
             $credentials = $request->only('username', 'password');
     
             if (!Auth::attempt($credentials)) {
                 return back()->withErrors([
                     'username' => 'Username atau password salah.',
                 ])->withInput();
             }
     
             // Regenerate session untuk keamanan
             $request->session()->regenerate();
     
             return redirect()->intended(route('dashboard', absolute: false));
         }
     }
     
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
