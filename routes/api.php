<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\UserVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/registration', RegistrationController::class);
Route::post('/login', LoginController::class);

////////////
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store'])->middleware('verified');

    Route::get('/services', ServiceController::class)->middleware('verified');
    Route::patch('/users/{user}/verify', UserVerificationController::class);
});


///////////
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/tickets', [AdminTicketController::class, 'index']);
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show']);
    Route::patch('/tickets/{ticket}', [AdminTicketController::class, 'update']);
});
