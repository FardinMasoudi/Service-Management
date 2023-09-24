<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    public function __invoke()
    {
        $services = Service::get();

        return ServiceResource::collection($services);
    }
}
