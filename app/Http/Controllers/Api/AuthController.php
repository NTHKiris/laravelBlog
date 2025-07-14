<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRequest;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{


    public function login(LoginRequest $request)
    {

        try {
            $request->authenticate();

            // $user = User::where('email', $request->email)->first();
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'Account does not exist'
                ], 404);
            }
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'error' => 'Incorect password'
                ], 404);
            }
            $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Logined successfully!',
                'token' => $token,
                'expires_at' => now()->addDay()
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

    }
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Logout failed: ' . $th->getMessage()
            ], 500);
        }
    }

    public function register(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create($data);
            $token = $user->createToken('auth_token', ['*'], now()->addDay())->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Registered successful',
                'token' => $token,
                'expires_at' => now()->addDay()->toDateTimeString(),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'Register failed: ' . $th->getMessage()
            ]);
        }
    }
    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar?->path,
                'role' => $user->role->slug
            ]

        ]);
    }





}
