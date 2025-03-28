<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $request->authenticate();
    
        // Jika login berhasil, redirect berdasarkan role
        $user = Auth::user();
        $request->session()->regenerate();
    
        // Redirect berdasarkan role
        if ($user->hasRole('Admin')) {
            return redirect()->intended('Role.Admin.Akun.index');
        } elseif ($user->hasRole('Guru')) {
            return redirect()->intended('Role.Guru.Course.index');
        } elseif ($user->hasRole('Operator')) {
            return redirect()->intended('Role.Operator.Guru.index');
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->intended('Role.Siswa.Course.index');
        }
    
        return redirect()->intended('/dashboard');
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