<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use ErrorException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $authKey = Str::random(32);
            session(['auth_key' => $authKey]);

            return response()->json([
                "error" => false,
                "message" => "User logged in successfully!",
                "auth_key" => $authKey,
            ]);
        }

        return response()->json([
            "error" => true,
            "email" => "The provided credentials do not match our records.",
        ], 422);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('auth_key');
        return response()->json([
            "error" => false,
            "message" => "User logged out successfully!",
        ]);
    }
}
