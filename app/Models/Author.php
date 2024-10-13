<?php

namespace App\Models;

use App\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_name',
    ];

    public function series() {
        return $this->hasMany(Series::class);
    }

}
