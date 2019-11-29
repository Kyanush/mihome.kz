<?php
namespace App\Services;

use App\Contracts\OrderInterface;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Mail;

class ServiceOrder implements OrderInterface
{


    public static function productDelete($product_id, $order_id)
    {
        $order = Order::find($order_id);
        $order->products()->detach($product_id);
        self::totalOrder($order_id);
        return true;
    }

    public static function productAdd($product_id, $order_id, $quantity = 1, $price = 0)
    {
        $product = Product::with(['specificPrice' => function($query){
            $query->DateActive();
        }])->find($product_id);

        if($product)
        {
            if($price == 0)
            {
                if($product->specificPrice)
                    $price = $product->getReducedPrice();
                else
                    $price = $product->price;
            }


            //findOrNew
            $order = Order::find($order_id);

            $order->products()->syncWithoutDetaching([$product_id =>
                [
                    'name'       => $product->name,
                    'sku'        => $product->sku,
                    'price'      => $price,
                    'quantity'   => $quantity
                ]
            ]);

            self::totalOrder($order_id);
        }else{
            return false;
        }
    }

    public static function totalOrder($order_id)
    {
        $order = Order::find($order_id);
        $order->total = $order->total();
        return $order->save();
    }

    public static function orderSendMessage($order_id){
        if(env('APP_TEST') == 0)
        {
            $order = Order::find($order_id);
            if (!$order)
                return false;

            $emails = [];

            $settings = Setting::where('key', 'order_notification_email')->get();
            foreach ($settings as $setting)
                $emails[] = $setting->value;

            if($order->user_email)
                $emails[] = $order->user_email;

            if(count($emails) > 0)
            {
                $subject = env('APP_NAME') . ' - ' . 'заказ №:' . $order->id;
                Mail::send('mails.new_order', ['order' => $order, 'subject' => $subject], function($m) use($subject, $emails)
                {
                    $m->to($emails)->subject($subject);
                });
            }
        }
        return true;
    }

}
