<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
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
        $request->authenticate(); // Memanggil metode authenticate dari LoginRequest

        // Jika sampai sini, berarti pengguna sudah berhasil login
        $user = Auth::user();

        // Periksa apakah pengguna adalah operator dan statusnya tidak aktif
        if ($user->hasRole('Operator')) {
            $operator = $user->operator; // Mengambil data operator terkait

            if ($operator && $operator->status_aktif === 'tidak aktif') {
                // Jika status operator tidak aktif, logout dan tampilkan pesan kesalahan
                Auth::logout();
                return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }
        }

        $request->session()->regenerate();

        // Redirect berdasarkan peran pengguna
        if ($user->hasRole('Admin')) {
            return redirect()->intended('Role.Admin.Akun.index');
        } elseif ($user->hasRole('Guru')) {
            return redirect()->intended('Role.Guru.Course.index');
        } elseif ($user->hasRole('Operator')) {
            return redirect()->intended('Role.Operator.Guru.index');
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->intended('Role.Siswa.Course.index');
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
