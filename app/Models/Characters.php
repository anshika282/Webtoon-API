<?php

namespace App\Models;

use App\Models\Series;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Characters extends Model
{
    use HasFactory;
    protected $fillable = [
        'c_name',
        'webtoon_id',
        'summary',
        'role',
        'image'
    ];

    public function series() : Returntype {
        return $this->belongsTo(Series::class);  
    }

}
