<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Mencoba untuk mengautentikasi kredensial pengguna.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Mengambil kredensial email dan password dari request
        $credentials = $this->only('email', 'password');

        // Coba autentikasi menggunakan kredensial
        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            // Jika autentikasi gagal, hit rate limiter dan lempar pengecualian validasi
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Hapus rate limiter jika autentikasi berhasil
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Pastikan permintaan login tidak dibatasi karena terlalu banyak percobaan.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        // Periksa apakah sudah terlalu banyak percobaan login
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            event(new Lockout($this));

            $seconds = RateLimiter::availableIn($this->throttleKey());

            // Lempar pengecualian validasi dengan pesan throttle
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Mendapatkan kunci throttle untuk rate limiting permintaan ini.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        // Membuat kunci throttle berdasarkan email dan IP
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
