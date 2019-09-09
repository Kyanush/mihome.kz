<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Order;
use App\Requests\SaveOrderRequest;
use App\Tools\Helpers;
use App\User;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;

class OrderController extends AdminController
{

    public function list(Request $request)
    {
        $filters = $request->all();

        $sort = Helpers::sortConvert($filters['sort'] ?? false);
        $column = $sort['column'];
        $order  = $sort['order'];

        $list =  Order::with([
            'user' => function($query){
                $query->select(['id', 'name']);
            },
            'status',
        ])
        ->Filters($filters)
        ->OrderBy($column, $order)
        ->paginate($request->input('perPage', 10));

        return  $this->sendResponse($list);
    }

    public function view($id)
    {
        $order = Order::with([
            'user',
            'status',
            'statusHistory' => function($query){
                $query->with(['status', 'user']);
            },
            'shippingAddress',
            'carrier',
            'products',
            'payment'
        ])->findOrFail($id);

        return  $this->sendResponse([
            'order'        => $order,
            'whereOrdered' => $order->whereOrdered()
        ]);
    }

    public function orderSave(SaveOrderRequest $request)
    {
        $data = $request->input('order');

        $order = Order::findOrNew($data["id"]);
        $order->fill($data);
        if($order->save())
        {
            foreach ($data['products'] as $product)
            {
                $pivot = $product['pivot'];
                if(isset($pivot['is_delete']))
                {
                    ServiceOrder::productDelete($pivot['product_id'], $order->id);
                }else{
                    ServiceOrder::productAdd($pivot['product_id'], $order->id, $pivot['quantity'], $pivot['price']);
                }
            }
        }

        return  $this->sendResponse($order->id);
    }

    public function users()
    {
        $users = User::with('addresses')->OrderBy('id', 'DESC')->get();

        $data = $users->map(function ($item) {
            return [
                'id'        => $item->id,
                'name'      => $item->name . ' ' . $item->surname,
                'addresses' => $item->addresses
            ];
        });

        return  $this->sendResponse($data);
    }

    public function orderDelete($order_id){
        $orderDelete = Order::destroy($order_id);
        return  $this->sendResponse($orderDelete);
    }

    public function newOrdersCount(){
        $newOrdersCount = intval(Order::new()->count());
        return  $this->sendResponse($newOrdersCount);
    }

}