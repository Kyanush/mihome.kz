<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class OrderProduct extends Model
{

    protected $table = 'order_product';
    protected $fillable = [
        'product_id',
        'order_id',
        'name',
        'sku',
        'price',
        'quantity'
    ];

}
