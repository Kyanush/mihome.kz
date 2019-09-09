<?php
namespace App\Services;

use App\Contracts\CartInterface;
use App\Models\Carrier;
use App\Models\Cart;
use App\Tools\Helpers;
use Auth;



class ServiceCart implements CartInterface
{

    public static function cartSave(int $product_id, int $quantity = 0)
    {
        $cart = Cart::currentUser()->first();
        if(!$cart)
        {
            $data = ['visit_number' => Helpers::visitNumber()];
            if(Auth::check())
                $data['user_id'] = Auth::user()->id;

            $cart = Cart::create($data);
        }

        $cartItem = $cart->cartItems->where('product_id', $product_id)->first();
        if(!$cartItem)
        {
            return $cart->cartItems()->create([
                'product_id' => $product_id,
                'quantity'   => $quantity > 0 ? $quantity : 1
            ]) ? true : false;
        }else{
            $cartItem->fill([
                'quantity'   => $quantity > 0 ? $quantity : ($cartItem->quantity + 1)
            ]);
            return $cartItem->save() ? true : false;
        }
    }

    public static function cartDelete(int $product_id)
    {
        $cart = Cart::currentUser()->first();
        $cartItem = $cart->cartItems()->where('product_id', $product_id)->first();
        if($cartItem)
        {
            if($cartItem->delete())
            {
                $cartItems = $cart->cartItems()->where('product_id', $product_id)->get();
                if(!$cartItems)
                {
                  return $cart->delete() ? true : false;
                }
                return true;
            }
        }
        return false;
    }

    public static function cartTotal($carrier_id = 0)
    {
        $quantity = $sum = 0;

        $cartProductsList = self::cartProductsList();

        foreach ($cartProductsList as $item)
        {
            $quantity += $item->quantity;
            $sum      += $item->quantity * ($item->product->specificPrice ? $item->product->getReducedPrice() : $item->product->price);
        }

        if($carrier_id > 0)
            $sum += Carrier::find($carrier_id)->price;

        return [
            'quantity' => $quantity,
            'sum'      => $sum
        ];
    }

    public static function cartProductsList(){
        $cart = Cart::currentUser()->first();
        if($cart){
            $cartItems = $cart->cartItems()->with(['product' => function($query){
                $query->with(['specificPrice' => function($query){
                    $query->dateActive();
                },
                'categories']);

            }])->get();
            return $cartItems;
        }
        return [];
    }

    public static function cartDeleteAll(){
        $cart = Cart::currentUser()->first();
        if($cart){
            $cart->cartItems()->delete();
            $cart->delete();
            return true;
        }
        return false;
    }

}