<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required']
        ]);

        $validateData['password'] = Hash::make($request->password);

        $user = User::create($validateData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken
        ], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required']
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'User ini tidak terdaftar, silahkan cek kembali'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'user' => auth()->user(),
            'access_token' => $accessToken
        ], 201);

    }


}
