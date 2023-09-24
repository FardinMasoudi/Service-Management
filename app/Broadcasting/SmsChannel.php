<?php

namespace App\Broadcasting;

use App\Models\User;
use Illuminate\Notifications\Notification;

class SmsChannel
{

    public function getKey()
    {
        return 'SmsChannel';
    }
    public function send($notifiable, Notification $notification)
    {
        $sms = $notification->toSms($notifiable);

        $sms->send();
    }
}
