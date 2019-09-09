<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tools\Helpers;
use Auth;

class Cart extends Model
{

    protected $table = 'carts';
    protected $fillable = [
        'visit_number',
        'user_id'
    ];

    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem', 'cart_id', 'id');
    }

    public function scopeCurrentUser($query){
        $query->where(function ($query){
            $query->where('visit_number', Helpers::visitNumber())
                  ->orWhere('user_id',    Auth::user()->id ?? 0);
        });
        return $query;
    }

}