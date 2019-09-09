<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Tools\Helpers;

class CarrierController extends Controller
{

    public function listCarriers()
    {
        $carriers = Carrier::OrderBy('id')->get();

        $data = $carriers->map(function ($item) {
            return [
                'id'            => $item->id,
                'name'          => $item->name,
                'format_price'  => Helpers::priceFormat($item->price),
                'price'         => $item->price,
                'delivery_text' => $item->delivery_text,
                'logo'          => $item->pathLogo(true)
            ];
        });

        return  $this->sendResponse($data);
    }

}