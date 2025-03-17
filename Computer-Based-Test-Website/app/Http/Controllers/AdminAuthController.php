<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function create()
    {
        return view('auth.admin-login'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_admin) { 
                return redirect()->intended('admin/operators'); 
            }
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai admin.']);
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah.']);
    }
}