<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
<<<<<<< HEAD:Computer-Based-Test-Website/Web/app/Http/Controllers/Auth/AuthenticatedSessionController.php
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
=======
{
    $request->authenticate();

    $request->session()->regenerate();

    // Debugging tambahan
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return back()->withErrors(['login' => 'Login gagal, cek kembali email dan password!']);
>>>>>>> 8728113ee655d933cc2186178185296f41c8fe3b:Computer-Based-Test-Website/app/Http/Controllers/Auth/AuthenticatedSessionController.php
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
