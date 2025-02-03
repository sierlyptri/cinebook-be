<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seats;
use App\Models\Showtimes;
use App\Models\Bookings;
use Illuminate\Support\Facades\Validator;

class SeatsController extends Controller
{
    public function index($showtimeId)
    {
        $showtime = Showtimes::with('seats')->find($showtimeId);

        if (!$showtime) {
            return response()->json(['message' => 'Showtime not found'], 404);
        }
        $availableSeats = $showtime->seats()->where('status', 'kosong')->get();
        
        return response()->json([
            'showtime' => $showtime->movies->judul,
            'theater' => $showtime->theaters->nama,
            'available_seats' => $availableSeats
        ]);
    }

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

        $showtimeId = $request->input('showtimes_id');
        $seatsId = $request->input('seats_id');
        
        $seats = Seats::whereIn('id', $seatsId)->where('status', 'kosong')->get();

        if ($seats->count() !== count($seatsId)) {
            return response()->json(['message' => 'Some selected seats are already booked'], 422);
        }

        Seats::whereIn('id', $seatsId)->update(['status' => 'terisi']);

        return response()->json([
            'message' => 'Seats successfully reserved',
            'reserved_seats' => $seatsId,
        ]);
    }
    public function book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'showtimes_id' => 'required|exists:showtimes,id',
            'seats_id' => 'required|array',
            'seats_id.*' => 'exists:seats,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $showtimesId = $request->input('showtimes_id');
        $seatsId = $request->input('seats_id');
        $showtimes = Showtimes::find($showtimesId);
        $seatCount = count($seatsId);
        $pricePerSeat = 45000;
        $totalPrice = $seatCount * $pricePerSeat;

        $booking = Bookings::create([
            'showtimes_id' => $showtimesId,
            'seats_id' => json_encode($seatsId),
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
            'total_price' => $totalPrice,
            'payment_method' => 'QR Payment',
        ]);
    }
}
