<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Adrianorosa\GeoLocation\GeoLocation;
use Stevebauman\Location\Facades\Location;





class LocationController extends Controller
{
    public function index(Request $request)
    {
dd( $request->sessin());
if ($position = Location::get('112.134.119.117')) {
    // Successfully retrieved position.
    echo $position->countryName;
    echo $position->cityName;
   dd($position);
} else {
    echo  "Failed retrieving position.";
}
            $userIp = $request->ip();

       //     $locationData = \Location::get($userIp);



$details = GeoLocation::lookup($userIp);

echo $details->getIp();
// 8.8.8.8

echo $details->getCity();
// Mountain View

echo $details->getRegion();
// California

echo $details->getCountry();
// United States

echo $details->getLatitude();
// 37.386

echo $details->getLongitude();
// -122.0838

var_dump($details->toArray());   
            dd($userIp);

    }
}