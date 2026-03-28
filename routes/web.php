<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home'); // Ele vai procurar o arquivo Home.vue em Pages
});

Route::get('/tickets', [TicketController::class, 'index']);
