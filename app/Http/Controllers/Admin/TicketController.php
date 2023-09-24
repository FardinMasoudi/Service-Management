<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\TicketManagement;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('service', 'user')
            ->get();

        return TicketResource::collection($tickets);
    }

    public function show(Ticket $ticket)
    {
        app(TicketManagement::class)->updateStatus(
            $ticket,
            Ticket::STATUSES['SEENBYADMIN']
        );

        return TicketResource::make($ticket);
    }

    public function update(Ticket $ticket, UpdateTicketRequest $request)
    {
        app(TicketManagement::class)->updateStatus(
            $ticket,
            $request->status
        );

        return response()->json(200);
    }
}
