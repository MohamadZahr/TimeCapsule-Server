<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    protected $fillable = [
        'longitude', 'latitude', 'city', 'country', 'address'
    ];

    function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }
}
