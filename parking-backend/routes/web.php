<?php

use App\Http\Controllers\WebhookController;
use App\Notifications\ReservationPaymentSuccesful;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

//    $reservation = \App\Models\Reservation::findOrFail('297');
//    $reservation->user->notify(new ReservationPaymentSuccesful($reservation));
    return view('welcome');
});

Route::post(
    '/stripe/webhook',
    [WebhookController::class, 'handleWebhook']
)->name('cashier.webhook');


