<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFilterLink extends Model
{
     protected $table = 'category_filter_links';
     protected $fillable = [
         'name',
         'link',
         'category_id',
         'sort'
	];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

}