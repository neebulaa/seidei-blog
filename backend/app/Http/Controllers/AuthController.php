<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|min:6|regex:/^[a-z0-9_.]+$/"
        ], [
            "password.regex" => "Password can only contains Alphanumeric, underscore (_) or dot (.)"
        ]);

        if ($validator->fails()) {
            return response([
                "message" => "Invalid fields!",
                "errors" => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($validator->validated())) {
            return response([
                "message" => "Wrong credentials!"
            ], 401);
        }

        return response([
            "message" => "Welcome to Seidei!",
            "user" => auth()->user(),
            "access_token" => auth()->user()->createToken(uniqid())->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response([
            "message" => "Logout success"
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|min:3|max:255',
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|regex:/^[a-z0-9_.]+$/"
        ]);

        if ($validator->fails()) {
            return response([
                "message" => "Invalid fields!",
                "errors" => $validator->errors()
            ], 422);
        }

        $validated_data = $validator->validated();
        $user = User::create($validated_data);
        Auth::login($user);

        return response([
            "message" => "Welcome to Seidei!",
            "user" => auth()->user(),
            "access_token" => auth()->user()->createToken(uniqid())->plainTextToken
        ]);
    }
}
