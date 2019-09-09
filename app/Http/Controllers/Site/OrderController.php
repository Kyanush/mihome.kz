<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Tools\Helpers;
use Auth;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orderHistory(){

        $orders = Order::withCount('products')->with('status')->where('user_id', Auth::user()->id)->OrderBy('id', 'DESC')->get();

        return view('site.order_history', ['orders' => $orders]);
    }


    public function orderHistoryDetail($order_id){

        $order = Order::where('user_id', Auth::user()->id)->find($order_id);

        return view('site.order_history_detail', ['order' => $order]);
    }
}

