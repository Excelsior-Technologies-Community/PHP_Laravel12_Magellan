<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Clickbar\Magellan\Data\Geometries\Point;

class Port extends Model
{
    protected $fillable = [
        'name',
        'country',
        'location'
    ];

    protected $casts = [
        'location' => Point::class
    ];
}