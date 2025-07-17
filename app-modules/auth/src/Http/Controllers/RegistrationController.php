<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RecaptchaService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('auth::register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'recaptcha_token' => ['required', 'string'],
        ]);

        // Verify reCAPTCHA
        $recaptcha = new RecaptchaService();
        if (!$recaptcha->verify($request->recaptcha_token, 'register')) {
            throw ValidationException::withMessages([
                'email' => __('Please verify that you are not a robot.'),
            ]);
        }

        // Remove recaptcha_token from validated data before creating user
        unset($validated['recaptcha_token']);
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        return redirect(LaravelLocalization::localizeUrl(route('customer-dashboard.index', absolute: false)));
    }
}
