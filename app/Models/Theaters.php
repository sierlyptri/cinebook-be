<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theaters extends Model
{
    use HasFactory;
    protected $table = 'theaters';
    protected $primaryKey = 'id';
    protected $fillable = ['nama'];
    public function showtimes()
    {
        return $this->hasMany(Showtimes::class);
    }
}
