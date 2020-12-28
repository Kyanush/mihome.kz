<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ServiceOrder;
use App\Services\ServiceTelegram;
use App\Services\ServiceUser;
use App\Models\Order;
use Auth;
use App\User;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    public function subscribe(Request $request){

        $product_id = $request->input('product_id');
        $phone      = $request->input('phone');


        //заказ
        $order = new Order();
        $order->type_id     = 5;
        $order->status_id   = 7;
        $order->user_phone  = $phone;

        if($order->save())
        {
            ServiceOrder::productAdd($product_id, $order->id);
            ServiceOrder::orderSendMessage($order->id);

            $serviceTelegram = new ServiceTelegram();
            $serviceTelegram->sendOrder($order->id);

            return $this->sendResponse(['order_id' => $order->id]);
        }

        return $this->sendResponse(true);
    }

}