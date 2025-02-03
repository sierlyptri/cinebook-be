<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtimes extends Model
{
    use HasFactory;
    protected $table = 'showtimes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'movies_id', 
        'theaters_id', 
        'jam_tayang'
    ];
    public function movies()
    {
        return $this->belongsTo(Movies::class);
    }
    public function theaters()
    {
        return $this->belongsTo(Theaters::class);
    }
    public function seats()
    {
        return $this->hasMany(Seats::class);
    }
}
