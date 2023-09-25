<?php

namespace App\Http\Services\VerificationCodeDrivers;

use App\Mail\VerificationCodeEmail;
use Illuminate\Support\Facades\Mail;

class EmailVerificationCodeDriver implements VerificationCodeDriver
{
    public function sendVerificationCode($user, $verificationCode)
    {
        Mail::to($user->email)->send(new VerificationCodeEmail($verificationCode));
    }
}
