<?php

namespace App\Utils;

class GetDistanceBetweenTwoGeoPoints
{
    private const MY_FIXED_LATITUDE = 22.711555;
    private const MY_FIXED_LONGITUDE = 90.3609395;
    public const EARTH_RADIUS_IN_KM = 6371;

    public static function execute(float $latitude, float $longitude): float
    {
        $latFromRad = deg2rad(self::MY_FIXED_LATITUDE);
        $longFromRad = deg2rad(self::MY_FIXED_LONGITUDE);
        $latToRad = deg2rad($latitude);
        $longToRad = deg2rad($longitude);

        // Haversine Formula
        $latDiff = $latToRad - $latFromRad;
        $longDiff = $longToRad - $longFromRad;

        $val = pow(sin($latDiff / 2), 2) + cos($latFromRad) * cos($latToRad) * pow(sin($longDiff / 2), 2);

        $res = 2 * asin(sqrt($val));

        return ($res * self::EARTH_RADIUS_IN_KM);
    }
}
