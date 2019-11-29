<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeProductValue extends Model
{
    protected $table = 'attribute_product_value';
    protected $fillable = [
    	'product_id',
    	'attribute_id',
        'name',
    	'value'
	];

    protected static function boot()
    {
        parent::boot();

        //Событие до
        static::Deleting(function($modal) {

        });

    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute', 'attribute_id', 'id');
    }



}
