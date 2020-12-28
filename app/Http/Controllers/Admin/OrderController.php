<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductStock;
use App\Requests\SaveOrderRequest;
use App\Services\ServiceOrderAdd;
use App\Tools\Helpers;
use App\User;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use DB;
//use App\Services\ServiceTelegram;

class OrderController extends AdminController
{

    public function orderBarcode(Request $request){

        $order_id = $request->input('order_id');
        $barcode  = $request->input('barcode');

        if(!$order_id)
        {
            $order = new Order();
            $order->save();
            $order_id = $order->id;
        }

        if($order_id and $barcode)
        {
            $productStock = ProductStock::where('imei', $barcode)->first();
            if($productStock)
            {
                 if($productStock->quantity == 1)
                 {
                     if($productStock->orderProduct)
                     {
                         if($productStock->orderProduct->order->status_id !== 6)
                             return $this->sendResponse('Уже есть', 422);
                     }
                 }

                $soa = new ServiceOrderAdd();
                $soa->product_id       = $productStock->product_id;
                $soa->order_id         = $order_id;
                $soa->quantity         = 1;
                $soa->product_stock_id = $productStock->id;
                $soa->productAdd();

                return $this->sendResponse($order_id);

            }

            $product = Product::where('sku', $barcode)->first();
            if($product)
            {
                $soa = new ServiceOrderAdd();
                $soa->product_id       = $product->id;
                $soa->order_id         = $order_id;
                $soa->quantity         = 1;
                $soa->productAdd();
                return $this->sendResponse($order_id);
            }

        }

        return $this->sendResponse('Ничего не найдено', 422);

    }

    public function list(Request $request)
    {
        $filters = $request->all();

        $product_name = $filters['product_name'] ?? '';
        $category_id  = $request->input('category_id');

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
        ->filters($filters)
        ->where(function ($query) use ($product_name, $category_id){
            if($product_name or $category_id)
            {
                $query->whereHas('products', function($query) use ($product_name, $category_id){

                    if($product_name)
                        $query->where(DB::raw('t_products.name'), 'like', '%' . $product_name . '%');

                    if($category_id)
                        $query->filters(['category_id' => $category_id]);

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
            'order'          => $order,
            'whereOrdered'   => $order->whereOrdered(),
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
                    OrderProduct::destroy($pivot['id']);
                    //ServiceOrder::productDelete($pivot['product_id'], $order->id);
                }else{

                    $soa = new ServiceOrderAdd();
                    $soa->id               = $pivot['id'] ?? '';
                    $soa->product_id       = $pivot['product_id'];
                    $soa->order_id         = $order->id;
                    $soa->quantity         = $pivot['quantity'];
                    $soa->price            = $pivot['price'];
                    $soa->price0           = 0;
                    $soa->product_stock_id = $pivot['product_stock_id'] ?? '';
                    $soa->name             = $pivot['name'];
                    $soa->productAdd();

                   // ServiceOrder::productAdd($pivot['product_id'], $order->id, $pivot['quantity'], $pivot['price'], true, $pivot['product_stock_id']);
                }
            }

            //$serviceTelegram = new ServiceTelegram();
            //$serviceTelegram->sendOrder($order->id);

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

    public function orderPrint($order_id){
        $order = Order::find($order_id);
        return view('reports.order_print', ['order' => $order]);
    }

}
