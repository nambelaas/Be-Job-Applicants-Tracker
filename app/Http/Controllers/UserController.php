<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->userService->registerUser($data);

        if (array_key_exists('error', $user)) {
            return response()->json([
                'error' => $user['error'],
                'message' => $user['message']
            ], 500);
        }

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $user['token'] ?? null
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->userService->loginUser($data);

        if (array_key_exists('error', $user)) {
            return response()->json([
                'error' => $user['error'],
                'message' => $user['message']
            ], 500);
        }

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $user['token'] ?? null
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }
}
