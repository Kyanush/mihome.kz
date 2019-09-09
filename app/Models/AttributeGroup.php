<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $table = 'attribute_groups';
    protected $fillable = [
        'name',
        'sort'
    ];

    public function attributes()
    {
        return $this->hasMany('App\Models\Attribute', 'attribute_group_id', 'id');
    }

}