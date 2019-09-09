<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ServiceCity;
use Illuminate\Support\Facades\Cookie;

class CityController extends Controller
{

    public function setCity($city_code){

        ServiceCity::setCityCookie($city_code);

        return $this->sendResponse(
            $_COOKIE["city_code"]
        );
    }

}