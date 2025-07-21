<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Showtimes
 *
 * @package App\Models
 * @property int $id
 * @property int $movies_id
 * @property int $theaters_id
 * @property string $jam_tayang
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Movies $movies
 * @property-read \App\Models\Theaters $theaters
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Seats[] $seats
 * @property-read int|null $seats_count
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes whereMoviesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes whereTheatersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes whereJamTayang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Showtimes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Showtimes extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'movies_id', 
        'theaters_id', 
        'jam_tayang'
    ];

    /**
     * Get the movie that owns the showtime.
     */
    public function movies()
    {
        return $this->belongsTo(Movies::class);
    }

    /**
     * Get the theater that owns the showtime.
     */
    public function theaters()
    {
        return $this->belongsTo(Theaters::class);
    }

    /**
     * Get the seats for the showtime.
     */
    public function seats()
    {
        return $this->hasMany(Seats::class);
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }
}