<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Order;
use App\Requests\SaveOrderRequest;
use App\Services\ServiceTelegram;
use App\Tools\Helpers;
use App\User;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use DB;

class OrderController extends AdminController
{

    public function list(Request $request)
    {
        $filters = $request->all();

        $product_name = $filters['product_name'] ?? '';

        $sort = Helpers::sortConvert($filters['sort'] ?? false);
        $column = $sort['column'];
        $order  = $sort['order'];

        $list =  Order::with([
            'user' => function($query){
                $query->select(['id', 'name']);
            },
            'status',
            'type'
        ])
        ->Filters($filters)
        ->where(function ($query) use ($product_name){
            if($product_name)
            {
                $query->whereHas('products', function($query) use ($product_name){
                    $query->where(DB::raw('t_products.name'), 'like', '%' . $product_name . '%');
                });
            }
        })
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

            $serviceTelegram = new ServiceTelegram();
            $serviceTelegram->sendOrder($order->id);

        }



        return  $this->sendResponse($order->id);
    }

    public function users()
    {
        $users = User::OrderBy('id', 'DESC')->get();

        $data = $users->map(function ($item) {
            return [
                'id'        => $item->id,
                'name'      => $item->name . ' ' . $item->surname
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
