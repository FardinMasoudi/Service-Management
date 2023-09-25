<?php

namespace App\Http\Services\VerificationCodeDrivers;

use App\Models\VerificationCode;
use Illuminate\Support\Str;

class VerificationCodeService
{
    public function sendVerificationCode($user, $driver)
    {
        $verificationCode = $this->generateVerificationCode();

        (VerificationCodeDriverFactory::make($driver))
            ->sendVerificationCode($user, $verificationCode);

        $this->saveVerificationCode($user, $verificationCode, $driver);
    }

    public function generateVerificationCode(): string
    {
        return Str::random(6);
    }

    public function saveVerificationCode($user, $verificationCode, $driver)
    {
        VerificationCode::create([
            'user_id' => $user->id,
            'driver' => $driver,
            'code' => $verificationCode
        ]);
    }
}
