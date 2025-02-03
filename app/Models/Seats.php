<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtimes_id',
        'nomor_kursi',
        'status'
    ];

    public function showtime()
    {
        return $this->belongsTo(Showtimes::class, 'showtimes_id');
    }

    public function bookings()
    {
        return $this->belongsToMany(Bookings::class, 'booking_seat');
    }
}
