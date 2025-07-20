<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect to social provider
     */
    public function redirect(string $provider): RedirectResponse
    {
        if (!$this->isSocialLoginEnabled($provider)) {
            return redirect()->route('login')->withErrors([
                'social' => ucfirst($provider) . ' login is currently disabled.'
            ]);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle social provider callback
     */
    public function callback(string $provider, Request $request): RedirectResponse
    {
        if (!$this->isSocialLoginEnabled($provider)) {
            return redirect()->route('login')->withErrors([
                'social' => ucfirst($provider) . ' login is currently disabled.'
            ]);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'social' => 'Unable to authenticate with ' . ucfirst($provider) . '. Please try again.'
            ]);
        }

        // Check if user exists with this social ID
        $user = $this->findOrCreateUser($socialUser, $provider);

        if ($user) {
            Auth::login($user, true);
            $user->update(['last_login_at' => now()]);
            
            return redirect()->intended(route('dashboard', absolute: false));
        }

        return redirect()->route('login')->withErrors([
            'social' => 'Unable to create or login user. Please try again.'
        ]);
    }

    /**
     * Find or create user from social provider data
     */
    private function findOrCreateUser($socialUser, string $provider): ?User
    {
        $providerIdField = $provider . '_id';
        
        // First, try to find user by social provider ID
        $user = User::where($providerIdField, $socialUser->id)->first();
        
        if ($user) {
            // Update avatar if social provider has a newer one
            if ($socialUser->avatar && $socialUser->avatar !== $user->avatar) {
                $user->update(['avatar' => $socialUser->avatar]);
            }
            return $user;
        }

        // Try to find user by email
        $user = User::where('email', $socialUser->email)->first();
        
        if ($user) {
            // Link this social account to existing user
            $user->update([
                $providerIdField => $socialUser->id,
                'avatar' => $socialUser->avatar ?: $user->avatar,
                'email_verified_at' => $user->email_verified_at ?: now(),
            ]);
            return $user;
        }

        // Create new user
        $user = User::create([
            'name' => $socialUser->name ?: $socialUser->nickname ?: 'User',
            'email' => $socialUser->email,
            'email_verified_at' => now(), // Social login emails are considered verified
            $providerIdField => $socialUser->id,
            'avatar' => $socialUser->avatar,
            'password' => Hash::make(Str::random(32)), // Random password
            'password_set' => false, // User hasn't set a password
            'role' => 'customer', // Default role
        ]);

        event(new Registered($user));

        return $user;
    }

    /**
     * Check if social login is enabled for the provider
     */
    private function isSocialLoginEnabled(string $provider): bool
    {
        $enabledKey = 'SOCIAL_LOGIN_' . strtoupper($provider) . '_ENABLED';
        return env($enabledKey, false) === 'true' || env($enabledKey, false) === true;
    }

    /**
     * Get enabled social providers
     */
    public static function getEnabledProviders(): array
    {
        $providers = [];
        
        if (env('SOCIAL_LOGIN_GOOGLE_ENABLED', false) === 'true' || env('SOCIAL_LOGIN_GOOGLE_ENABLED', false) === true) {
            $providers[] = 'google';
        }
        
        if (env('SOCIAL_LOGIN_FACEBOOK_ENABLED', false) === 'true' || env('SOCIAL_LOGIN_FACEBOOK_ENABLED', false) === true) {
            $providers[] = 'facebook';
        }

        return $providers;
    }
}