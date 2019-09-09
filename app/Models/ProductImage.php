<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class ProductImage extends Model
{

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'product_images';
    protected $fillable = [
    	'product_id',
    	'name',
    	'order'
	];


    public function imagePath($firstSlash = false)
    {
        return $this->productFileFolder($firstSlash) . $this->name;
    }

    public function productFileFolder($firstSlash = false)
    {
        return ($firstSlash ? '/' : '') . config('shop.products_path_file') . $this->product_id . '/';
    }

    protected static function boot()
    {
        parent::boot();

        //Событие до
        static::Deleting(function($modal) {
            if($modal->name)
                File::delete($modal->imagePath());
        });
    }

}
