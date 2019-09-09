<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use App\Tools\Upload;

class Payment extends Model
{

    protected $table = 'payments';
    public $timestamps = false;
    protected $fillable = [
    	'name',
    	'logo'
	];

    public function scopeSearch($query, $search)
    {
        if($search)
            $query->whereLike('name',   $search);

        return $query;
    }

 	public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            $obj->deleteLogo();
        });

        //Событие до
        static::Saving(function($model){
            if(is_uploaded_file($model->logo))
            {
                if($model->id)
                    self::find($model->id)->deleteLogo();

                $upload = new Upload();
                $upload->setWidth(100);
                $upload->setHeight(100);
                $upload->setPath(config('shop.payments_path_file'));
                $upload->setFile($model->logo);

                $model->logo = $upload->save();
            }
        });
    }

    public function pathLogo($firstSlash = false)
    {
        if(!empty($this->logo))
            return ($firstSlash ? '/' : '') . config('shop.payments_path_file') . $this->logo;
        else
            false;
    }

    public function deleteLogo(){
        return File::delete($this->pathLogo());
    }


}
