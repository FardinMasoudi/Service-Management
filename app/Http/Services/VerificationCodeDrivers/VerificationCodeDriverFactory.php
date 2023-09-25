<?php

namespace App\Http\Services\VerificationCodeDrivers;

class VerificationCodeDriverFactory
{
    public static function make($driver)
    {
        return match ($driver) {
            'email' => new EmailVerificationCodeDriver(),
            'sms' => new SmsVerificationCodeDriver(),
            default => throw new \InvalidArgumentException("Invalid driver:$driver"),
        };
    }
}
