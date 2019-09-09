<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Requests\SubscribeRequest;


class SubscribeController extends Controller
{

    public function subscribe(SubscribeRequest $request){

        $product_id = $request->input('product_id', 0);

        $subscribe = Subscribe::where('email', $request->input('email'))->where(function ($query) use ($product_id){
            if($product_id > 0)
                $query->where('product_id', $product_id);
            else
                $query->whereNull('product_id');
        })->first();

        if(!$subscribe)
        {
            Subscribe::create($request->all());
        }

        return $this->sendResponse($subscribe ? false : true);
    }

}