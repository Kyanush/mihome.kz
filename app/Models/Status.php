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

    public function scopeWhereUse($query, $where_use){
        return $query->where('where_use', $where_use);
    }

    public function scopeDefaultValue($query){
        return $query->where('default', 1);
    }

}