<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ProductFeaturesWishlist extends Model
{

    protected $table = 'product_features_wishlist';
    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public function scopeIsAuthUser($query)
    {
        $query->where('user_id', Auth::check() ? Auth::user()->id : 0);
        return $query;
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

}