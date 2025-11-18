<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
        public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 0,
                'message' => 'Email atau Password salah'
            ], 401);
        }

            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
            'status' => 1,
            'message' => 'Login berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);

        
    }

        public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:20|unique:users,username',
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return [
            "status" => 1,
            "data" => $user
        ];
    }

     public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Logout Berhasi'
        ], 200);
    }


}
