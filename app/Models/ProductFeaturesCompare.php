<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tools\Helpers;

class ProductFeaturesCompare extends Model
{

    protected $table = 'product_features_compare';
    protected $fillable = [
        'visit_number',
        'product_id'
    ];

    public function scopeSearchVisitNumber($query, $visit_number = '')
    {
        if(empty($visit_number))
            $visit_number = Helpers::visitNumber();

        $query->where('visit_number', $visit_number);
        return $query;
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}