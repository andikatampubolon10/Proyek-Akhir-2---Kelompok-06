<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('identifier', 'password');

        // Cek jika user ada berdasarkan email atau username
        $user = User::where('email', $credentials['identifier'])
                    ->orWhere('email', $credentials['identifier'])
                    ->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'identifier' => 'Email atau password tidak terdaftar.'
            ]);
        }

        // Cek jika akun aktif
        if (!$user->is_active) {
            return back()->withErrors([
                'identifier' => 'Status akun tidak aktif.'
            ]);
        }

        // Cek apakah password benar
        if (Hash::check($credentials['password'], $user->password)) {
            // Login berhasil
            auth()->login($user);

            // Regenerasi session untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Redirect berdasarkan peran pengguna
            if ($user->hasRole('Admin')) {
                return redirect()->intended('Role.Admin.Akun.index')->with('success', 'Login berhasil!');
            } elseif ($user->hasRole('Guru')) {
                return redirect()->intended('Role.Guru.Course.index')->with('success', 'Login berhasil!');
            } elseif ($user->hasRole('Operator')) {
                return redirect()->intended('Role.Operator.Guru.index')->with('success', 'Login berhasil!');
            } elseif ($user->hasRole('Siswa')) {
                return redirect()->intended('Role.Siswa.Course.index')->with('success', 'Login berhasil!');
            }
        } else {
            // Password salah
            return back()->withErrors([
                'identifier' => 'Email atau password salah.'
            ]);
        }
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate token to prevent session fixation attack
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login');
    }
}
