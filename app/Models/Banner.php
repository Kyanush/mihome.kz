<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Banner extends Model
{

    protected $table = 'banners';
    public $timestamps = false;
    protected $fillable = [
    	'name',
    	'link',
    	'body'
	];

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['name', 'link'],   $search);

        return $query;
    }

}
