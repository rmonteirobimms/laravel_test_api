<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        $token = $user->createToken('authToken')->plainTextToken;

        return response([
            'user' => $user, 
            'accessToken' => $accessToken, 
            'token' => $token
        ], 201);
    }

    public function login(Request $request){
        return auth()->attempt($request->all());
    }

    public function logout(Request $request){
        //->token()->revoke();
        //return $request;
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'You have been successfully logged out!'
        ], 200);
    }
}
