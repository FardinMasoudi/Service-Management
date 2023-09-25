<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserVerificationRequest;
use App\Models\User;
use App\Models\VerificationCode;

class UserVerificationController extends Controller
{
    public function __invoke(User $user, UserVerificationRequest $request)
    {
        $verificationCode = VerificationCode::query()
            ->where('code', $request->code)
            ->where('driver', $request->driver)
            ->where('user_id', $user->id)
            ->first();

        if (!$verificationCode) {
            return response()->json(['response' => 'invalid verification code'], 401);
        }

        $columnToUpdate = ($request->driver === 'email') ? 'email_verified_at' : 'mobile_verified_at';

        $user->update([
            $columnToUpdate => now()
        ]);

        return response()->json(['response' => '200'], 200);
    }
}
