<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{

    protected $table = 'cart_items';
    protected $fillable = [
        'product_id',
        'quantity',
        'cart_id'
    ];

    public function cart(){
        return $this->belongsTo('App\Models\Cart', 'cart_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}