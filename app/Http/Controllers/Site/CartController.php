<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Requests\CheckoutRequest;
use App\Requests\OneClickOrderRequest;
use App\Services\ServiceCart;
use App\Services\ServiceOrder;
use App\Services\ServiceUser;
use App\Tools\Helpers;
use App\Tools\Seo;
use App\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function cartSave(Request $request){
        $product_id = intval($request->input('product_id'));
        $quantity   = intval($request->input('quantity', 0));

        return $this->sendResponse(
            ServiceCart::cartSave($product_id, $quantity)
        );
    }

    public function cartDelete($product_id){
        return $this->sendResponse(
            ServiceCart::cartDelete($product_id)
        );
    }

    public function cartTotal($carrier_id = 0){

        $cartTotal = ServiceCart::cartTotal($carrier_id);
        $cartTotal['sum'] = Helpers::priceFormat($cartTotal['sum']);

        return $this->sendResponse($cartTotal);
    }

    public function checkout(){
        $seo = Seo::pageSeo('checkout');

        $user = null;
        if(Auth::check())
            $user = User::with('addresses')->find(Auth::user()->id);

        return view('site.checkout',[
            'seo'  => $seo,
            'user' => $user
        ]);
    }

    public function listCart(){
        $cartProductsList = ServiceCart::cartProductsList();


        $data = [];

        if($cartProductsList)
            $data = $cartProductsList->map(function ($item) {
                return [
                    'product_id'             => $item->product->id,
                    'product_name'           => $item->product->name,
                    'product_price'          => Helpers::priceFormat($item->product->price),
                    'product_specific_price' => Helpers::priceFormat($item->product->getReducedPrice()),
                    'product_url'            => $item->product->detailUrlProduct(),
                    'product_photo'          => $item->product->pathPhoto(true),
                    'quantity'               => $item->quantity,
                    'sum'                    => Helpers::priceFormat($item->quantity * $item->product->getReducedPrice())
                ];
            });


        return $this->sendResponse($data);
    }

    public function saveCheckout(CheckoutRequest $request)
    {
        //Пользователь
        $user = ServiceUser::findOrNewUserCart(
            $request->input('user.email'),
            $request->input('user.name'),
            $request->input('user.phone')
        );

        //адрес
        $address_id = $request->input('address.id', 0);
        if(!$address_id)
        {
            $address = $user->addresses()->create($request->input('address'));
            $address_id = $address->id;
        }


        //заказ
        $order = new Order();
        $order->type                = 1;
        $order->user_id             = $user->id;
        $order->status_id           = 1;//новый
        $order->carrier_id          = $request->input('carrier_id');
        $order->shipping_address_id = $address_id;
        $order->comment             = $request->input('comment', '');
        $order->payment_id          = $request->input('payment_id');
        if($order->save())
        {
            //товара заказа
            foreach (ServiceCart::cartProductsList() as $item)
                ServiceOrder::productAdd($item->product_id, $order->id, $item->quantity);

            //удалить корзину
            ServiceCart::cartDeleteAll();

            ServiceOrder::orderSendMessage($order->id);

            return $this->sendResponse(['order_id' => $order->id]);
        }

        return $this->sendResponse(false);
    }



    public function oneClickOrder(OneClickOrderRequest $request)
    {
        //Пользователь
        $user = ServiceUser::findOrNewUserCart(
            $request->input('email'),
            $request->input('name'),
            $request->input('phone')
        );

        //заказ
        $order = new Order();
        $order->type                = 2;
        $order->user_id             = $user->id;
        $order->status_id           = 1;//новый
        if($order->save())
        {
            ServiceOrder::productAdd($request->input('product_id'), $order->id);
            ServiceOrder::orderSendMessage($order->id);

            return $this->sendResponse(['order_id' => $order->id]);
        }
        return $this->sendResponse(false);
    }

}
