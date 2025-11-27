<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketApiController;
use App\Http\Controllers\Api\ReportApiController;

Route::name('api.')->group(function () {

    // CRUD + show/edit/delete automático
    Route::apiResource('tickets', TicketApiController::class);

    // Cambiar estado de ticket
    Route::put('tickets/{ticket}/status', [TicketApiController::class, 'changeStatus'])
        ->name('tickets.status');

    // Reportes
    Route::get('reports/tickets-by-status', [ReportApiController::class, 'ticketsByStatus'])
        ->name('reports.tickets');
});
