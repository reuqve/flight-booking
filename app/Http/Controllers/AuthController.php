<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}
