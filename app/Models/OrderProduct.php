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
        'quantity',
        'product_stock_id'
    ];


    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function stock()
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id', 'id');
    }

}
