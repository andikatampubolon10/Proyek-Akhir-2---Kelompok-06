<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Operator;

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
        $this->ensureIsNotRateLimited();

        // Mencari user berdasarkan email
        $user = User::where('email', $this->input('identifier'))->first();

        if (!$user || !Auth::attempt(['email' => $this->input('identifier'), 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => 'Email atau password salah.',
            ]);
        }

        // Validasi status akun
        $this->checkUserStatus($user);

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'identifier' => 'Terlalu banyak percakapan. Silakan coba lagi dalam ' . $seconds . ' detik.',
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('identifier')) . '|' . $this->ip());
    }

    /**
     * Validasi apakah akun pengguna (operator, guru, siswa) aktif.
     */
    public function checkUserStatus(User $user)
    {
        // Cek status siswa
        $siswa = Siswa::where('id_user', $user->id)->first();
        if ($siswa && $siswa->status === 'Tidak Aktif') {
            throw ValidationException::withMessages([
                'identifier' => 'Akun siswa Anda tidak aktif.',
            ]);
        }

        // Cek status guru
        $guru = Guru::where('id_user', $user->id)->first();
        if ($guru && $guru->status === 'Tidak Aktif') {
            throw ValidationException::withMessages([
                'identifier' => 'Akun guru Anda tidak aktif.',
            ]);
        }

        // Cek status operator
        $operator = Operator::where('id_user', $user->id)->first();
        if ($operator && $operator->status === 'Tidak Aktif') {
            throw ValidationException::withMessages([
                'identifier' => 'Akun operator Anda tidak aktif.',
            ]);
        }
    }
}
