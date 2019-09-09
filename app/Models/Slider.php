<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use App\Tools\Upload;

class Slider extends Model
{

    protected $table = 'sliders';
    protected $fillable = [
        'name',
        'link',
        'image',
        'sort',
        'show_where',
        'created_at',
        'updated_at',
        'active'
	];

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['name', 'link'],   $search);

        return $query;
    }

 	public static function boot()
    {

        parent::boot();
        static::deleting(function($obj) {
            $obj->deleteImage();
        });

        //Событие до
        static::Saving(function($model){
            if(is_uploaded_file($model->image))
            {
                if($model->id)
                    self::find($model->id)->deleteImage();

                $upload = new Upload();
                $upload->setPath(config('shop.sliders_path_file'));
                $upload->setFile($model->image);

                $model->image = $upload->save();
            }
        });

    }

    public function pathImage($firstSlash = false)
    {
        if(!empty($this->image))
            return ($firstSlash ? '/' : '') . config('shop.sliders_path_file') . $this->image;
        else
            false;
    }

    public function deleteImage(){
        return File::delete($this->pathImage());
    }


}
