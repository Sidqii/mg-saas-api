<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\Authentication\LoginRequest;

class AuthController extends Controller
{
    /**
     * Make personal_access_tokens for login header.
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Invalid credential',
            ], 401);
        }

        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            $key = 'verify-email:' . $user->id;

            if (RateLimiter::tooManyAttempts($key, 1)) {
                return response()->json([
                    'message' => 'Please wait before requesting another verification email'
                ], 429);
            }

            $user->sendEmailVerificationNotification();

            RateLimiter::hit($key, 300);

            return response()->json([
                'message' => 'Email not verified. Please verified email first'
            ], 403);
        }

        $token = $user->createToken(
            'auth_token',
            ['*'],
            now()->addMinutes(60)
        )->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'data' => [
                'user_id' => $user->id,
                'email' => $user->email,
                'email_verified' => $user->email_verified_at,
            ]
        ]);
    }

    /**
     * Delete personal_access_tokens session.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
