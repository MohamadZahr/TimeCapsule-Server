<?php
namespace App\Services;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;


class IpLocationService
{
    static function getLocation(Request $request)
    {
        $ip = $request->ip();
        if(!$ip == '127.0.0.1'){
            $position = Location::get($ip);
        }
        else{
            $position = Location::get('91.151.226.72');
        }

        $locationArray = [
            'longitude' => $position->longitude,
            'latitude'  => $position->latitude,
            'city'      => $position->cityName,
            'country'   => $position->countryName,
            'address'   => $position->cityName . ', ' . $position->countryCode,
        ];

        return $locationArray;
    }
}