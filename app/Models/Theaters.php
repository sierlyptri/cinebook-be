<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Theaters
 *
 * @package App\Models
 * @property int $id
 * @property string $nama
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Showtimes[] $showtimes
 * @property-read int|null $showtimes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters query()
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theaters whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Theaters extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    /**
     * Get the showtimes for the theater.
     */
    public function showtimes()
    {
        return $this->hasMany(Showtimes::class);
    }
}
