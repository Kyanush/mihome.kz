<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class City extends Model
{

    protected $table = 'cities';
    protected $fillable = [
    	'name',
        'code',
        'sort',
        'active'
	];

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['name', 'code'],   $search);

        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::Saving(function($model) {
            $model->code = str_slug(empty($model->code) ? $model->name : $model->code);
        });

    }

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

}
