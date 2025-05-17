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
        
        if ($user->hasRole('Admin')) {
            return redirect()->route('Admin.Akun.index');
        } elseif ($user->hasRole('Guru')) {
            return redirect()->route('Guru.Course.index');
        } elseif ($user->hasRole('Siswa')) {
            return redirect()->route('Siswa.Course.index');
        } elseif ($user->hasRole('Operator')) {
            return redirect()->route('Operator.Kurikulum.index');
        }
    
        return redirect()->route('login');
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