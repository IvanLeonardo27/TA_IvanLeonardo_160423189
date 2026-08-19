<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login'    => ['nullable', 'string'],
            'email'    => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     * Mendukung login menggunakan Email ATAU Kode Pengguna (user_code)
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginInput = trim($this->input('login') ?? $this->input('email') ?? '');
        $password   = $this->input('password');
        $remember   = $this->boolean('remember');

        if (empty($loginInput)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau Kode Pengguna wajib diisi.',
            ]);
        }

        // Tentukan apakah input berupa email atau kode pengguna
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_code';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $password,
        ];

        // Jika bukan format email, coba juga cari format case-insensitive
        if (! Auth::attempt($credentials, $remember)) {
            // Coba fallback ke email jika sebelumnya user_code gagal, atau sebaliknya
            $fallbackField = ($fieldType === 'email') ? 'user_code' : 'email';
            $fallbackCreds = [$fallbackField => $loginInput, 'password' => $password];

            if (! Auth::attempt($fallbackCreds, $remember)) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        }

        // Catat waktu login terakhir
        $user = Auth::user();
        if ($user) {
            $user->update(['last_login' => now()]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $loginInput = $this->input('login') ?? $this->input('email') ?? '';
        return Str::transliterate(Str::lower($loginInput).'|'.$this->ip());
    }
}
