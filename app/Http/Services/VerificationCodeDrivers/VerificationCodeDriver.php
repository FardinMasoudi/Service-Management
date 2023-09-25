<?php

namespace App\Http\Services\VerificationCodeDrivers;

interface VerificationCodeDriver
{
    public function sendVerificationCode($user, $verificationCode);
}
