<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Movies
 *
 * @package App\Models
 * @property int $id
 * @property string $judul
 * @property string $genre
 * @property int $durasi
 * @property float $rating
 * @property int $usia
 * @property string $poster
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Showtimes[] $showtimes
 * @property-read int|null $showtimes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Movies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movies query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereDurasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereUsia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movies whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Movies extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'genre',
        'durasi',
        'rating',
        'usia',
        'poster'
    ];

    /**
     * Get the showtimes for the movie.
     */
    public function showtimes()
    {
        return $this->hasMany(Showtimes::class);
    }
}