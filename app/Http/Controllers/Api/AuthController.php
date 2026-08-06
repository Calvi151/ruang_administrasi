<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::with('employee')->where('nip', $request->nip)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'NIP atau password salah.'
            ], 401);
        }

        $token = $user->createToken('mobile-app-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load('employee');
        
        return response()->json([
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.'
        ]);
    }
}
