<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Seats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    /**
     * Tampilkan semua booking (bisa difilter per user).
     */
    public function index()
    {
        $bookings = Bookings::with(['showtimes.movies', 'showtimes.theaters'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($bookings);
    }

    /**
     * Simpan booking baru (proses reservasi).
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

        $seatsId = $request->seats_id;

        DB::beginTransaction();
        try {
            $seats = Seats::whereIn('id', $seatsId)
                        ->where('status', 'kosong')
                        ->lockForUpdate()
                        ->get();

            if ($seats->count() !== count($seatsId)) {
                DB::rollBack();
                return response()->json(['message' => 'Some selected seats are already reserved'], 422);
            }

            // Hitung total harga, misal per kursi 50.000
            $totalPrice = count($seatsId) * 50000;

            $booking = Bookings::create([
                'user_id' => auth()->id(), // atau $request->user_id
                'showtimes_id' => $request->showtimes_id,
                'seats' => json_encode($seatsId),
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
                'booking_code' => strtoupper(uniqid('BK-')),
            ]);

            // Update status kursi jadi "terisi"
            Seats::whereIn('id', $seatsId)->update(['status' => 'terisi']);

            DB::commit();

            return response()->json([
                'message' => 'Booking successful',
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Booking failed', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Tampilkan detail 1 booking.
     */
    public function show(string $id)
    {
        $booking = Bookings::with(['showtimes.movies', 'showtimes.theaters'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }

    /**
     * Batalkan booking dan kosongkan kembali kursinya.
     */
    public function destroy(string $id)
    {
        $booking = Bookings::find($id);

        if (!$booking || $booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Booking not found or unauthorized'], 403);
        }

        DB::beginTransaction();
        try {
            // Ubah kursi jadi kosong lagi
            $seatIds = json_decode($booking->seats, true);
            Seats::whereIn('id', $seatIds)->update(['status' => 'kosong']);

            $booking->delete();

            DB::commit();
            return response()->json(['message' => 'Booking cancelled']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to cancel booking'], 500);
        }
    }

    /**
     * Batalkan booking berdasarkan kode booking.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,success,failed,cancelled',
        ]);

        $booking = Bookings::findOrFail($id);
        $booking->payment_status = $request->payment_status;
        $booking->save();

        return response()->json([
            'message' => 'Booking status updated successfully',
            'data' => $booking
        ], 200);
    }
}