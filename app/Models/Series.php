<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Genres;
use App\Models\Characters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'status',
        'author_id'
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }

    // public function genre(){
    //     return $this->belongsToMany(Genres::class,'genres_series', 'series_id', 'genre_id');
    // }

    public function character(){
        return $this->hasMany(Characters::class,'webtoon_id','id');
    }


}
