<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
     * Handle login request.
     */
    public function login(LoginRequest $request)
    {
        // Memanggil metode authenticate dari LoginRequest
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            // Menyimpan pesan error di session untuk ditampilkan di view
            return back()->with('error', 'Email atau password salah.');
        }
    
        $user = Auth::user();
    
        if ($user->hasRole('Operator')) {
            $operator = $user->operator;
            if ($operator && $operator->status_aktif === 'tidak aktif') {
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
