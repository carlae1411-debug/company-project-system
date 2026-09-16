<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Login Rate Limiting
        |--------------------------------------------------------------------------
        */

        $throttleKey = Str::transliterate(
            Str::lower($request->input('email')) .
            '|' .
            $request->ip()
        );

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {

            $seconds = RateLimiter::availableIn($throttleKey);

            $minutes = max(1, ceil($seconds / 60));

            return back()
                ->withErrors([
                    'email' =>
                        'Too many failed login attempts. Please try again in ' .
                        $minutes .
                        ' minute.',
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Attempt Login
        |--------------------------------------------------------------------------
        */

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            /*
            |--------------------------------------------------------------------------
            | Successful Login
            |--------------------------------------------------------------------------
            */

            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            ActivityLog::record(
                'logged_in',
                'User logged in successfully.'
            );

            return redirect()
                ->intended(route('dashboard'))
                ->with(
                    'success',
                    'Welcome back!'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Failed Login
        |--------------------------------------------------------------------------
        */

        RateLimiter::hit($throttleKey, 60);

        ActivityLog::record(
            'failed_login',
            'Failed login attempt for email: ' .
            $request->input('email')
        );

        $attempts = RateLimiter::attempts($throttleKey);

        if ($attempts >= 3) {

            return back()
                ->withErrors([
                    'email' =>
                        'Too many failed login attempts. Please wait 1 minute before trying again.',
                ])
                ->onlyInput('email');
        }

        $remaining = 3 - $attempts;

        return back()
            ->withErrors([
                'email' =>
                    'The provided credentials are incorrect. ' .
                    $remaining .
                    ' attempt' .
                    ($remaining === 1 ? '' : 's') .
                    ' remaining.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        ActivityLog::record(
            'logged_out',
            'User logged out of the system.'
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}