<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{

    protected $table = 'product_stock';
    protected $fillable = [
    	'product_id',
    	'quantity',
        'arrival_id',
        'price',
        'imei'
	];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function arrival()
    {
        return $this->belongsTo(ProductStockArrival::class, 'arrival_id', 'id');
    }

    public function orderProduct(){
        return $this->belongsTo(OrderProduct::class, 'id', 'product_stock_id');
    }

    public function orderProducts(){
        return $this->hasMany(OrderProduct::class, 'product_stock_id', 'id');
    }

}