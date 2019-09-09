<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;
use App\Models\AttributeProductValue;


class AttributeValue extends Model
{
    protected $table = 'attribute_values';
    protected $fillable = [
    	'attribute_id',
    	'value',
        'code',
        'props'
	];

    protected static function boot()
    {
        parent::boot();
        //Событие после
        static::Deleting(function($model){
            $path =  config('shop.attributes_path_file') . $model->value;
            if($model->value and File::exists(public_path($path)))
                File::delete($path);


            //удалить
            AttributeProductValue::where('attribute_id', $model->attribute_id)->where('value', $model->value)->delete();


            return $model;
        });

        //Событие до
        static::Saving(function($model) {
            //чпу
            $model->code = str_slug(empty($model->code) ? $model->value : $model->code);

            //обновить multiple_select, dropdown
            if(isset($model->id))
            {
                AttributeProductValue::where('attribute_id', $model->attribute_id)
                                     ->where('value', self::find($model->id)->value)
                                     ->update(['value' => $model->value]);
            }
        });

    }


    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute', 'attribute_id', 'id');
    }

}