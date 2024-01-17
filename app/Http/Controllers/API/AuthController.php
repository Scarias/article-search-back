<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Requests\APIRegisterRequest;
use App\Http\Requests\APILoginRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register method for atuhentication system.
     */
    public function registerUser(APIRegisterRequest $request) : JsonResponse {
        $credentials = $request->validated();

        $user = User::create($credentials);
        $token = $user
            ->createToken(env('API_TOKEN_NAME', 'USER_TOKEN'), ['crud-articles'])
            ->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => __('messages.register_success', ['name' => $user->name]),
            'token' => $token,
        ]);
    }

    /**
     * Login method for authentication system.
     */
    public function loginUser(APILoginRequest $request) : JsonResponse
    {
        $credentials = $request->validated();

        Auth::attempt($credentials);
        $request->session()->regenerate();
        $token = $request->user()
            ->createToken(env('API_TOKEN_NAME', 'USER_TOKEN'), ['crud-articles'])
            ->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => __('messages.login_success'),
            'token' => $token,
        ]);
    }
}
