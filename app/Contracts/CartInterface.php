<?php

namespace App\Contracts;

interface CartInterface
{
    public static function cartSave(int $product_id, int $quantity = 0);
    public static function cartDelete(int $product_id);
    public static function cartTotal($carrier_id = 0);
    public static function cartProductsList();
    public static function cartDeleteAll();
}