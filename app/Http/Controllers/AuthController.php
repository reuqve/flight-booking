<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request) {
        $validated = $request->validate([
            "fio" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "string", "min:6"],
            "avatar" => ["nullable", "string"],
        ]);

        $user = User::create([
            "fio" => $validated["fio"],
            "email" => $validated["email"],
            "password" => $validated["password"],
            "avatar" => $validated["avatar"] ?? 'default.png',
            "role" => "client",
        ]);
        
        $token = $user->createToken("api-token")->plainTextToken;

        return response()->json([
            "message" => "Registration successful",
            "token"=> $token,
            "user" => $user,
            ], 201);
    }
    public function login(Request $request) {
        $validated = $request->validate([
            "email"=> ["required", "email"],
            "password"=> ["required", "string"],
        ]);

        $user = User::where("email", $validated["email"])->first();

        if(!$user || !Hash::check($validated["password"], $user->password)) {
            return response()->json([
                "message" => "Login failed",
            ],403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
