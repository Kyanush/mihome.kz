<?php
namespace App\Services;

use App\Models\City;
use Illuminate\Support\Facades\Cookie;

class ServiceCity
{

    public static function listActiveSort(){
        $cities = City::isActive()->OrderBy('sort', 'ASC')->get();
        return $cities;
    }

    public static function groupingFirstLetters(){
        $data = [];
        $cities = self::listActiveSort();
        foreach ($cities as $city)
        {
            $first = mb_strtoupper(mb_substr( $city->name, 0, 1,'UTF8'));
            $data[$first][] = $city;
        }
        return $data;
    }

    public static function getCurrentCity(){

        $city_code = request()->city;
        if(empty($city_code))
            $city_code = Cookie::get('city_code', 'almaty');

        $city = City::isActive()->where('code', $city_code)->first();

        if(!$city)
            $city = City::isActive()->where('code', 'almaty')->first();

        self::setCityCookie($city_code);
        return $city;

        return false;
    }

    public static function setCityCookie($set_city_code)
    {
        $city_code = Cookie::get('city_code');
        if($city_code != $set_city_code)
        {
            Cookie::queue(Cookie::make('city_code', $set_city_code));
        }
    }

}