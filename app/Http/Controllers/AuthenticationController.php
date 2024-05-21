<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class AuthenticationController extends Controller
{
    //
    public function login(Request $request): JsonResponse
    {

        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        try {
            $credentials = [
                'name' => $request->name,
                'password' => $request->password,
            ];

            $user = User::where('name', $request->name)->first();


            if ($user && Hash::check($request->password, $user->password)) {
                // User authenticated successfully, create token using Passport

                $token = $user->createToken('authToken')->accessToken;

                $statusCode = 200;
                $message = 'Login successful';
                $data = [
                    'token' => $token,
                    'user' => $user, // Include user information if desired (be mindful of sensitive data)
                ];
            } else {
                $statusCode = 401;
                $message = 'Invalid name or password';
                $data = [];
            }
        } catch (\Exception $e) {
            $statusCode = 500;
            $message = $e->getMessage();
            $data = [];
        }

        return response()->json([
            'success' => $statusCode == 200 ? true : false,  // boolean
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }



    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete(); // Delete all tokens for this user

        return response()->json([
            "success" => true, // Optional: Include success status if needed
            'message' => 'Logged out successfully!'
        ]);
    }
}
