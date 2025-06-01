<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'imdb_id',
        'title',
        'year',
        'type',
        'poster',
        'plot',
        'director',
        'actors',
        'rating',
        'votes'
    ];

    protected $casts = [
        'year' => 'integer',
        'rating' => 'float',
        'votes' => 'integer'
    ];
} 