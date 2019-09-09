<?php

namespace App\Models;

use App\Tools\Helpers;
use Illuminate\Database\Eloquent\Model;

class YouWatchedProduct extends Model
{

    protected $table = 'you_watched_products';
    protected $fillable = [
        'visit_number',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function scopeSearchVisitNumber($query, $visit_number = '')
    {
        if(empty($visit_number))
            $visit_number = Helpers::visitNumber();

        $query->where('visit_number', $visit_number);
        return $query;
    }

}