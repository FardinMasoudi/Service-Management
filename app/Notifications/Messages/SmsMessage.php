<?php

namespace App\Notifications\Messages;

use App\Models\Ticket;
use Illuminate\Support\Facades\Http;

class SmsMessage
{
    public $from;
    public $to;
    public $description;
    public $baseUrl;

    public function __construct()
    {
        $this->from = config('sms.from');
        $this->baseUrl = config('sms.baseUrl');
    }

    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    public function send()
    {
        return Http::asForm()
            ->post($this->baseUrl, [
                'from' => $this->from,
                'to' => $this->to,
                'message' => $this->description
            ]);
    }
}
