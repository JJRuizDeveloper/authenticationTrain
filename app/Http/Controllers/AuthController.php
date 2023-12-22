<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created succesfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);


    }

    public function loginUser(loginRequest $request)
{
        if(!Auth::attemp($request->only(['email', 'pasword'])))
        {
            return response()->json([
                'status' => 'false',
                'message' => 'Email & Passoword are nor correct'
            ], 401);
        };

        $user= User::where('email', $request-> email)->first();

        return response()->json([
            'status' => 'true',
            'message' => 'Logged in succesfullly',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ]. 200);
    }
}
