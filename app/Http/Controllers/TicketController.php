<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('service')
            ->where('user_id', auth()->user()->id)
            ->get();

        return TicketResource::collection($tickets);
    }

    public function store(TicketRequest $request)
    {
        Ticket::query()->create([
            'service_id' => $request->service_id,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => Ticket::STATUSES['PENDING']
        ]);

        return response()->json(['code' => 200]);
    }
}
