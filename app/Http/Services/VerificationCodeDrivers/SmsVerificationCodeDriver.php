<?php

namespace App\Http\Services\VerificationCodeDrivers;

use App\Notifications\Messages\SmsMessage;

class SmsVerificationCodeDriver implements VerificationCodeDriver
{
    public function sendVerificationCode($user, $verificationCode)
    {
        app(SmsMessage::class)
            ->description($verificationCode)
            ->to($user->mobile)
            ->send();
    }
}
