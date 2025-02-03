<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;
    protected $fillable = ['showtimes_id', 'seats_id', 'total_price', 'payment_status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movies::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theaters::class);
    }

    public function showtimes()
    {
        return $this->belongsTo(Showtimes::class);
    }

    public function seats()
    {
        return $this->belongsToMany(Seats::class, 'booking_seat');
    }
}
