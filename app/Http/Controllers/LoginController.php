<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::query()->firstWhere('email', $request->email);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => [
                'password' => ['0' => __('auth.invalid-password')]]
            ], 403);
        }

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }
}
