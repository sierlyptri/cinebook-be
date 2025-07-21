<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seats;
use App\Models\Showtimes;
use App\Models\Bookings;
use Illuminate\Support\Facades\Validator;

class SeatsController extends Controller
{
    /**
     * Tampilkan kursi kosong untuk satu showtime.
     */
    public function index($showtimeId)
    {
        $showtime = Showtimes::with(['seats', 'movies', 'theaters'])->find($showtimeId);

        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }

        $availableSeats = $showtime->seats()->where('status', 'kosong')->get();

        return response()->json([
            'showtime' => $showtime->movies->judul ?? 'N/A',
            'theater' => $showtime->theaters->nama ?? 'N/A',
            'available_seats' => $availableSeats
        ]);
    }

    /**
     * Update status kursi menjadi "terisi".
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'showtimes_id' => 'required|exists:showtimes,id',
            'seats_id' => 'required|array',
            'seats_id.*' => 'exists:seats,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $seatsId = $request->input('seats_id');
        $seats = Seats::whereIn('id', $seatsId)->where('status', 'kosong')->get();

        if ($seats->count() !== count($seatsId)) {
            return response()->json(['message' => 'Some selected seats are already reserved'], 422);
        }

        // Tandai kursi sebagai terisi
        Seats::whereIn('id', $seatsId)->update(['status' => 'terisi']);

        return response()->json([
            'message' => 'Seats successfully reserved',
            'reserved_seats' => $seatsId,
        ]);
    }
}