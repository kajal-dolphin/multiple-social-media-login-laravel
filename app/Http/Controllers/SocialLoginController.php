<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handlProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->user();
            switch ($driver) {
                case "google":
                    $loginId = 'google_id';
                    break;
                case "facebook":
                    $loginId = 'facebook_id';
                    break;
                case "apple":
                    $loginId = 'apple_id';
                    break;
                case "tiktok":
                    $loginId = 'tiktok_id';
                    break;
                default:
                    $msg = 'Something went wrong.';
            }
            $finduser = User::where($loginId, $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                session()->flash('message', 'Login successful! Welcome back.');
                return redirect()->route('home');
            } else {
                $newUser = User::create([
                    'name' => isset($user->name) ? $user->name : $user->nickname,
                    'email' => $user->email,
                    'provider' => $driver,
                    'google_id' => $driver == "google" ? $user->id : null,
                    'facebook_id' => $driver == "facebook" ? $user->id : null,
                    'apple_id' => $driver == "apple" ? $user->id : null,
                    'tiktok_id' => $driver == "tiktok" ? $user->id : null,
                    'password' => Hash::make('12345678'),
                ]);
                Auth::login($newUser);
                // return response()->json(['message' => 'Registration successful!']);
                session()->flash('message', 'Registration successful! Welcome.');
                return redirect()->route('home');
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            session()->flash('error', 'Something went wrong during the login process. Please try again.');
            return redirect()->route('social-login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        session()->flash('success', 'You have been logged out.');

        return redirect()->route('home');

    }
}
