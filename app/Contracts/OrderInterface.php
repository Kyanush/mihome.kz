<?php

namespace App\Contracts;

interface OrderInterface
{
    public static function productDelete($product_id, $order_id);
    public static function productAdd($product_id, $order_id, $quantity = 1, $price = 0);
    public static function totalOrder($order_id);
    public static function orderSendMessage($order_id);
}