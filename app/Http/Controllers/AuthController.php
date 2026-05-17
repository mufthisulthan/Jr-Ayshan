<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = trim($credentials['username']);

        $user = User::query()
            ->where('email', $username)
            ->orWhere('name', $username)
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password. Please try again.',
            ], 422);
        }

        $request->session()->regenerate();
        session([
            'jr_user' => [
                'id' => $user->id,
                'username' => $user->email,
                'name' => $user->name,
                'role' => 'Administrator',
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => "Welcome, {$user->name}!",
            'user' => session('jr_user'),
            'redirect' => url('/dashboard'),
        ]);
    }
}
