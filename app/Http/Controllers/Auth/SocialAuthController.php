<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToGoogle()
    {
        return response()->json(['url' => Socialite::driver('google')->redirect()->getTargetUrl()]);
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Google login failed. Please try again.']);
        }

        // Check if the user already exists
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return response()->json(['message' => 'Login successful', 'user' => $existingUser]);
        } else {
            // Create a new user
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => null, // Google login doesn't require a password
                'provider_id' => $user->id,
                'provider' => 'google',
            ]);

            Auth::login($newUser);
            return response()->json(['message' => 'User registered and logged in successfully', 'user' => $newUser]);
        }
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirectToFacebook()
    {
        return response()->json(['url' => Socialite::driver('facebook')->redirect()->getTargetUrl()]);
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Facebook login failed. Please try again.']);
        }

        // Check if the user already exists
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
            return response()->json(['message' => 'Login successful', 'user' => $existingUser]);
        } else {
            // Create a new user
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => null, // Facebook login doesn't require a password
                'provider_id' => $user->id,
                'provider' => 'facebook',
            ]);

            Auth::login($newUser);
            return response()->json(['message' => 'User registered and logged in successfully', 'user' => $newUser]);
        }
    }
}
