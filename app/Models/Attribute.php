<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;
use DB;

class Attribute extends Model
{

    protected $table = 'attributes';
    protected $fillable = [
        'name',
        'type',
        'required',
        'code',
        'use_in_filter',
        'description',
        'attribute_group_id'
 	];


    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['name', 'type'],   $search);

        return $query;
    }

    public function scopeIsRequired($query)
    {
        return $query->where('required', 1);
    }

    public function scopeNoRequired($query)
    {
        return $query->where('required', 0);
    }

    protected static function boot()
    {
        parent::boot();

        //Событие до
    	static::deleting(function($model) {
	        if (count($model->sets) == 0) {

    	        foreach ($model->values as $item)
                    AttributeValue::destroy($item->id);

            } else {
    			return $model;
    		}
        });

        //Событие до
        static::Saving(function($model) {

            if (empty($model->attribute_group_id))
                $model->attribute_group_id = null;
            //чпу
            $model->code = str_replace("-", "_", str_slug(empty($model->code) ? $model->name : $model->code));;
        });

    }

    public function scopeUseInFilter($query)
    {
        return $query->where('use_in_filter', 1);
    }

	public function values()
    {
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id', 'id');
    }

    public function sets()
    {
    	return $this->belongsToMany('App\Models\AttributeSet', 'attribute_attribute_set', 'attribute_id', 'attribute_set_id');
    }

    public function attributeGroup()
    {
        return $this->belongsTo('App\Models\AttributeGroup', 'attribute_group_id', 'id');
    }

}
