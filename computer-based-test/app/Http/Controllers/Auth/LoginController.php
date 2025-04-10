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
        $request->authenticate(); 
    
        $user = Auth::user();
        
        // Check if the user is inactive based on their role
        if ($this->isUser Inactive($user)) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['Akun tidak aktif. Silakan hubungi administrator.'],
            ]);
        }
    
        $request->session()->regenerate();
    
        return $this->redirectUser BasedOnRole($user);
    }

    /**
     * Check if the user is inactive based on their role.
     */
    protected function isUser Inactive($user)
    {
        if ($user->hasRole('Operator')) {
            $operator = $user->operator;
            \Log::info('Operator status:', ['status' => $operator ? $operator->status_aktif : 'null']);
            if ($operator && $operator->status_aktif === 'tidak aktif') {
                return true;
            }
        }
    
        if ($user->hasRole('Siswa')) {
            $siswa = $user->siswa;
            \Log::info('Siswa status:', ['status' => $siswa ? $siswa->status_aktif : 'null']);
            if ($siswa && $siswa->status_aktif === 'tidak aktif') {
                return true;
            }
        }
    
        if ($user->hasRole('Guru')) {
            $guru = $user->guru;
            \Log::info('Guru status:', ['status' => $guru ? $guru->status_aktif : 'null']);
            if ($guru && $guru->status_aktif === 'tidak aktif') {
                return true;
            }
        }
    
        return false;
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectUser BasedOnRole($user)
    {
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