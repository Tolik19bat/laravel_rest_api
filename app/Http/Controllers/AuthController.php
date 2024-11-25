<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        return User::create($request->all());
    }

    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Неправильный емейл или пароль',
            ], 401);
        }

        // $user = Auth::user();
        $user = User::query()->where('email', $request->email)->first();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            // 'token' => $user->createToken("Token of user: {$user->name}")->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        try {
            /** @var \App\Models\User $user */
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Token removed']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error removing token: ' . $e->getMessage()], 500);
        }
    }
}
