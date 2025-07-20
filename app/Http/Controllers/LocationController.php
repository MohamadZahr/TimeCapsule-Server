<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $fillable = [
        'longitude', 'latitude', 'city', 'country', 'address'
    ];
}
