<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AttributeSet extends Model
{
    protected $table = 'attribute_sets';
    protected $fillable = ['name'];

	protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->attributes()->detach();
        });
    }

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike('name',   $search);
        return $query;
    }

	public function attributes() {
    	return $this->belongsToMany('App\Models\Attribute', 'attribute_attribute_set', 'attribute_set_id', 'attribute_id');
	}

}
