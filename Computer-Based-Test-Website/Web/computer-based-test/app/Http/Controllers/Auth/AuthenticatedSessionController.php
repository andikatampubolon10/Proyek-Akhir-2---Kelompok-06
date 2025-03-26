<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        // Redirect based on user role
        if ($user->hasRole('Admin')) {
            return redirect()->intended('Role.Admin.Akun.index');
        } elseif ($user->hasRole('Guru')) {
            return redirect()->intended('Role.Guru.Course.index');
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->intended('Role.Siswa.Course.index');
        } elseif ($user->hasRole('Operator')) {
            return redirect()->intended('Role.Operator.Guru.index');
        }

        return redirect()->intended('/dashboard');
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