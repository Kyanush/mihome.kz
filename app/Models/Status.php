<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $table = 'statuses';
    protected $fillable = [
        'name',
        'class',
        'where_use',
        'default'
    ];

    public function scopeCallbacksStatusId($query){
        return $query->where('where_use', 'callbacks_status_id');
    }

    public function scopeOrdersType($query){
        return $query->where('where_use', 'orders_type_id');
    }

    public function scopeDefaultValue($query){
        return $query->where('default', 1);
    }

}
