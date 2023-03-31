<?php

namespace App\Http\Controllers\API\Backend\Ticket;

use App\Http\Controllers\Controller;
use App\Models\TicketStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketStatusController extends Controller
{
    public function index(): JsonResponse
    {
        $status = TicketStatus::select('status_name', 'id')->get();
        return response()->json($status);
    }
}
