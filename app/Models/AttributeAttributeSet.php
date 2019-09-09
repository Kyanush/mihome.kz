<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeAttributeSet extends Model
{
    protected $table = 'attribute_attribute_set';
    protected $fillable = ['attribute_id', 'attribute_set_id'];
}