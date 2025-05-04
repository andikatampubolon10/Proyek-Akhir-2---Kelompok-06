<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
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
        
        $user = User::where('email', $this->input('identifier'))->first();
        
        if (!$user || !Auth::attempt(['email' => $this->input('identifier'), 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'identifier' => trans('auth.failed'),
            ]);
        }

        // Validasi status akun (operator, guru, siswa)
        $this->checkUserStatus($user);

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'identifier' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('identifier')).'|'.$this->ip());
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
