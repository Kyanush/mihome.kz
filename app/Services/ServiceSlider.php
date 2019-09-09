<?php
namespace App\Services;

use App\Models\Slider;

class ServiceSlider
{

    public static function listSlidersHomePage(){
        return Slider::where('show_where', 'home_page')->isActive()->OrderBy('sort')->get();
    }

}