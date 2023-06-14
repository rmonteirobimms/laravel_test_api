<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        $token = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user, 
            'accessToken' => $token
        ], 201);
    }

    public function login(LoginRequest $request){
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData["email"])->first();

        if(!$user || !Hash::check($validatedData["password"], $user->password)){
            return response(["message" => 'Invalid Credentials'], 401);
        }

        $token = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request){
        Auth::user()->tokens()->delete();

        return response([
            'message' => 'You have been successfully logged out!'
        ], 200);
    }
}
