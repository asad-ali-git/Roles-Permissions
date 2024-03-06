<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::guard('web')->attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $createdToken = $user->createToken(env('APP_PERSONAL_TOKEN'));
            $token = $createdToken->token;

            // WE CAN ADD REMEMBER ME HERE
            // if ($rememberMe) {
            //     $token->expires_at = Carbon::now()->addWeeks(1);
            // }

            $token->save();

            return response()->json([
                'error' => false,
                'message' => 'User logged in successfully!',
                'token' => $createdToken->accessToken,
                'token_type' => 'Bearer',
            ]);
        }

        throw ValidationException::withMessages([
            'error' => true,
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) {
            Auth::guard('web')->logout();
            $user = $request->user()->token();
            $user->revoke();

            return response()->json([
                'error' => false,
                'message' => 'User logged out successfully!',
            ]);
        } else {
            return response()->json([
                'error' => false,
                'message' => 'The user has already been logged out.',
            ]);
        }
    }
}
