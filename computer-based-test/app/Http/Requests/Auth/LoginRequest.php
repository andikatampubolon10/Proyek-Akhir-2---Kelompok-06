<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Operator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        // Validasi input menggunakan $this, karena berada dalam FormRequest
        $this->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ], [
            'identifier.required' => 'Email atau username harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        $this->ensureIsNotRateLimited();

        // Mencari user berdasarkan email atau username
        $user = User::where('email', $this->input('identifier'))
                    ->orWhere('email', $this->input('identifier'))
                    ->first();

        // Jika user tidak ditemukan
        if (!$user) {
            throw ValidationException::withMessages([
                'identifier' => 'Email atau password tidak terdaftar.',
            ]);
        }

        // Cek apakah password valid
        if (!Auth::attempt(['email' => $this->input('identifier'), 'password' => $this->input('password')])) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'identifier' => 'Email atau password salah.',
            ]);
        }

        // Validasi status akun
        $this->checkUserStatus($user);

        RateLimiter::clear($this->throttleKey());
    }

    // Fungsi untuk memastikan tidak ada rate limit
    public function ensureIsNotRateLimited(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            event(new Lockout($this));

            $seconds = RateLimiter::availableIn($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => 'Terlalu banyak percakapan. Coba lagi dalam ' . $seconds . ' detik.',
            ]);
        }
    }

    // Fungsi untuk validasi status akun
    public function checkUserStatus(User $user)
    {
        if ($user->is_active === false) {
            throw ValidationException::withMessages([
                'identifier' => 'Status akun tidak aktif.',
            ]);
        }

        // Cek status untuk siswa, guru, dan operator
        $siswa = Siswa::where('id_user', $user->id)->first();
        if ($siswa && $siswa->status === 'Tidak Aktif') {
            throw ValidationException::withMessages([
                'identifier' => 'Akun siswa Anda tidak aktif.',
            ]);
        }

        $guru = Guru::where('id_user', $user->id)->first();
        if ($guru && $guru->status === 'Tidak Aktif') {
            throw ValidationException::withMessages([
                'identifier' => 'Akun guru Anda tidak aktif.',
            ]);
        }

        $operator = Operator::where('id_user', $user->id)->first();
        if ($operator && $operator->status === 'Tidak Aktif') {
            throw ValidationException::withMessages([
                'identifier' => 'Akun operator Anda tidak aktif.',
            ]);
        }
    }

    // Throttle key untuk rate limiting
    public function throttleKey(): string
    {
        return Str::lower($this->input('identifier')) . '|' . $this->ip();
    }
}
