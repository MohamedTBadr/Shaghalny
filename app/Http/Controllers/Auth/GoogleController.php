<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')
                ->withErrors(['email' => __('Unable to sign in with Google. Please try again.')]);
        }

        $user = User::where('provider', 'google')
            ->where('provider_id', $googleUser->getId())
            ->first();

        if (! $user) {
            $user = User::where('email', $googleUser->getEmail())->first();
        }

        if ($user) {
            $user->forceFill([
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = new User([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'password' => null,
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => 'job_seeker',
            ]);
            $user->email_verified_at = now();
            $user->save();
        }

        Auth::login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
