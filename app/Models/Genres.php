<?php

namespace App\Models;

use App\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genres extends Model
{
    use HasFactory;
    protected $fillable = [
        'genre_type'
    ];

    public function anime() {
        return $this->belongsToMany(Series::class,'genres_series', 'genre_id', 'series_id');
    }

}
