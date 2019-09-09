<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAccessory extends Model
{

    protected $table = 'product_accessories';
    protected $fillable = [
        'accessory_product_id',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'accessory_product_id', 'id');
    }

}