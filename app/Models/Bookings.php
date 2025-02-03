<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bookings
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $movie_id
 * @property int $theater_id
 * @property int $showtimes_id
 * @property string $seats_id
 * @property int $total_price
 * @property string $payment_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Movies $movie
 * @property-read \App\Models\Theaters $theater
 * @property-read \App\Models\Showtimes $showtimes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Seats[] $seats
 * @property-read int|null $seats_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereSeatsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereShowtimesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereTheaterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bookings whereUserId($value)
 * @mixin \Eloquent
 */
class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'theater_id',
        'showtimes_id',
        'seats_id',
        'total_price',
        'payment_status',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movie associated with the booking.
     */
    public function movie()
    {
        return $this->belongsTo(Movies::class);
    }

    /**
     * Get the theater associated with the booking.
     */
    public function theater()
    {
        return $this->belongsTo(Theaters::class);
    }

    /**
     * Get the showtime associated with the booking.
     */
    public function showtimes()
    {
        return $this->belongsTo(Showtimes::class);
    }

    /**
     * Get the seats associated with the booking.
     */
    public function seats()
    {
        return $this->belongsToMany(Seats::class, 'booking_seat');
    }
}