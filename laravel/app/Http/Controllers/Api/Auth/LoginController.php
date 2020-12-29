<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'These credentials do not match our records.'
                ], 422);
            }

            $tokenResult = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'user' => new UserResource($user),
                'access_token' => $tokenResult,
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Error in Login',
            ], 500);
        }
    }
}
