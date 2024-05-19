<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            
            // Check if user already exists in your database
            $existingUser = User::where('social_id', $user->id)->first();

            if ($existingUser) {
                // Login existing user
                auth()->login($existingUser, true); // Remember for a week


            } else {
                // Create a new user with Google data (optional: ask for additional details if needed)
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => Hash::make('my-google'),

                ]);
                auth()->login($newUser, true);
            }

            return redirect()->intended('/dashboard/user'); // Redirect to intended route after login

        } catch (\Exception $e) {
            $errorResponse = [
                'message' => $e->getMessage(), // User-friendly error message
                'code' => $e->getCode(), // Optional: HTTP status code (if available)
                'file' => $e->getFile(), // Optional: File where the error occurred
                'line' => $e->getLine(), // Optional: Line number where the error occurred
            ];

            // Optionally filter out sensitive details in production
            if (app()->environment('production')) {
                unset($errorResponse['file'], $errorResponse['line']);
            }

            return response()->json($errorResponse, $e->getCode() ?: 500);
        }
    }

    public function handleFacebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();

            // Check if user already exists in your database
            $existingUser = User::where('social_id', $user->id)->first();

            if ($existingUser) {
                // Login existing user
                auth()->login($existingUser, true); // Remember for a week

                return \redirect('/dashboard/user');
            } else {
                // Create a new user with Google data (optional: ask for additional details if needed)
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'password' => Hash::make('my-facebook'),

                ]);
                auth()->login($newUser, true);
            }

            return redirect()->intended('/home'); // Redirect to intended route after login

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login using Google.');
        }
    }
}
