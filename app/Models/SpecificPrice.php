<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecificPrice extends Model
{

    protected $table = 'specific_prices';

    protected $fillable = [
                           'reduction',
                           'discount_type',
                           'start_date',
                           'expiration_date',
                           'product_id',
    ];



    public function scopeDateActive($query)
    {
        $current_date = date('Y-m-d H:i:s');

        return $query->where(function ($query) use ($current_date){
                    $query->where(function ($query) use ($current_date) {
                        $query->whereDate('start_date',      '<=', $current_date)
                              ->whereDate('expiration_date', '>=', $current_date);
                    });
                    $query->orWhere(function ($query) use ($current_date) {
                        $query->whereNull('start_date')
                              ->whereNull('expiration_date');
                    });
                    $query->orWhere(function ($query) use ($current_date) {
                        $query->whereDate('start_date', '<=', $current_date)
                              ->whereNull('expiration_date');
                    });
                    $query->orWhere(function ($query) use ($current_date) {
                        $query->whereNull('start_date');
                        $query->whereDate('expiration_date', '>=', $current_date);
                    });
               })
               ->where('reduction', '>', 0);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}