<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Seats
 *
 * @package App\Models
 * @property int $id
 * @property int $showtime_id
 * @property string $seat_number
 * @property string $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Showtimes $showtime
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bookings[] $bookings
 * @property-read int|null $bookings_count
 * @method static \Illuminate\Database\Eloquent\Builder|Seats newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seats newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seats query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seats whereShowtimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seats whereSeatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seats whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seats whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Seats extends Model
{
    use HasFactory;

    protected $fillable = [
        'showtimes_id',
        'seat_number',
        'status',
    ];

    /**
     * Get the showtime that owns the seat.
     */
    public function showtime()
    {
        return $this->belongsTo(Showtimes::class);
    }
}