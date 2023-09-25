<?php

namespace App\Http\Actions;

use App\Models\Ticket;
use Illuminate\Notifications\Notification;
use Exception;

class TicketManagement
{
    public function __construct(private Notification $notification){}

    public function updateStatus(Ticket $ticket, $status)
    {
        $this->validateStatusChange($status);

        $ticket->update(['status' => $status]);

        $this->sendNotification($ticket);

        if ($status == Ticket::STATUSES['COMPLETED']) {
            $ticket->update(['status' => Ticket::STATUSES['CLOSE']]);
        }
    }

    private function validateStatusChange($newStatus)
    {
        if ($newStatus == Ticket::STATUSES['CLOSE']) {
            throw new Exception('Cannot update ticket status');
        }
    }

    private function sendNotification(Ticket $ticket)
    {
        $ticket->notify($this->notification);
    }
}
