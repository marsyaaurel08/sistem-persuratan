<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses login pengguna
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email terdaftar
        $user = Pengguna::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email belum terdaftar!',
            ])->withInput();
        }

        // Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah!',
            ])->withInput();
        }

        // Jika email & password benar
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Berhasil login!');
    }

    /**
     * Logout pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Hapus autentikasi user saat ini

        $request->session()->invalidate(); // Hapus session lama
        $request->session()->regenerateToken(); // Regenerasi CSRF token baru

        return redirect('/login')->with('success', 'Anda telah keluar dari sesi.');
    }
}
