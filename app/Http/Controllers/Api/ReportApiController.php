<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class ReportApiController extends Controller
{
    public function ticketsByStatus()
    {
        $rows = Ticket::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $labels = $rows->pluck('status');
        $data   = $rows->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
        ]);
    }
}
