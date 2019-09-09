<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderStatus extends Model
{

    protected $table = 'order_statuses';
    protected $fillable = [
        'name',
        'notification',
        'description',
        'class'];

    public function scopeSearch($query, $search)
    {
        if($search)
            $query->whereLike(['name', 'description'],   $search);

        return $query;
    }

}
