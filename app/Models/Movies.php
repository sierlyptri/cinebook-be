<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use HasFactory;
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'genre',
        'durasi',
        'rating',
        'usia',
        'poster'
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtimes::class);
    }
}
