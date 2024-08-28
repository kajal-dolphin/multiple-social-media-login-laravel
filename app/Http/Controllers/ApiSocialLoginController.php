<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class ApiSocialLoginController extends Controller
{
    public function redirectToProvider($driver)
    {
        try {
            $redirectUrl = Socialite::driver($driver)->stateless()->redirect()->getTargetUrl();
            return response()->json(['url' => $redirectUrl]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to redirect to provider'], 500);
        }
    }

    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->stateless()->user();
            $loginId = $this->getLoginId($driver);

            $finduser = User::where($loginId, $user->id)->first();
            if ($finduser) {
                $token = $finduser->createToken('authToken')->plainTextToken;
                return response()->json(['message' => 'Login successful!', 'token' => $token]);
            } else {
                $newUser = User::create([
                    'name' => $user->name ?? $user->nickname,
                    'email' => $user->email,
                    'provider' => $driver,
                    'google_id' => $driver == "google" ? $user->id : null,
                    'facebook_id' => $driver == "facebook" ? $user->id : null,
                    'apple_id' => $driver == "apple" ? $user->id : null,
                    'tiktok_id' => $driver == "tiktok" ? $user->id : null,
                    'password' => Hash::make('12345678'),
                ]);

                $token = $newUser->createToken('authToken')->plainTextToken;
                return response()->json(['message' => 'Registration successful!', 'token' => $token]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong during the login process'], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    private function getLoginId($driver)
    {
        switch ($driver) {
            case "google":
                return 'google_id';
            case "facebook":
                return 'facebook_id';
            case "apple":
                return 'apple_id';
            case "tiktok":
                return 'tiktok_id';
            default:
                $msg = 'Something went wrong.';
                return $msg;
        }
    }
}
