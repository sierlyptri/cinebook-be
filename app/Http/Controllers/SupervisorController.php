<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Seats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupervisorController extends Controller
{
    /**
     * Tampilkan semua booking (bisa difilter per user).
     */
    public function index()
    {
        $bookings = Bookings::with(['showtimes.movies', 'showtimes.theaters'])
            ->latest()
            ->get();

        return response()->json($bookings);
    }
}