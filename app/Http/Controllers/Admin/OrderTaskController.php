<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Order;
use App\Models\OrderStatus;


class OrderTaskController extends AdminController
{

    public function list()
    {

        $orders = Order::with('products')
                        ->whereNotIn('status_id', [5, 6, 15, 14])
                        ->orderBy('created_at', 'DESC')
                        ->get()->groupBy('status_id');

        $status_id_arr = [];
        foreach ($orders as $status_id => $item)
        {
            $status_id_arr[] = $status_id;
        }

        return  $this->sendResponse([
            'orders'         => $orders,
            'order_status'   => OrderStatus::whereIn('id', $status_id_arr)->get()
        ]);
    }

}
