<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Subscribe extends Model
{

    protected $table = 'subscribe';
    protected $fillable = [
        'email',
        'product_id'
	];

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike('email',   $search);

        return $query;
    }

}