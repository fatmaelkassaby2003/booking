<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class SpecialistController extends Controller
{
    public function sign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Specialist::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'player successfully registered',
            'token' => $token,
            'user' => $user
        ], 201);
    }
    
    public function specialistLogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    try {
        if (!$token = auth('specialist')->attempt($credentials)) {
            return response()->json(['error' => 'Email or password is wrong'], 401);
        }
    } catch (JWTException $e) {
        return response()->json(['error' => 'Could not create token'], 500);
    }

    return response()->json([
        'message' => 'Login successfully',
        'token'   => $token,
        'specialist' => auth('specialist')->user(),
    ], 200);
}
}
