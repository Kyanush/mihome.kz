<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use App\Tools\Upload;

class News extends Model
{

    protected $table = 'news';
    protected $fillable = [
        'title',
        'code',
        'image',
        'preview_text',
        'detail_text',
        'active',
        'created_at'
	];

    public function scopeIsActive($query){
        $query->where("active", 1);
    }

    public function scopeIsNotActive($query){
        $query->where("active", 0);
    }

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['title', 'code', 'preview_text', 'detail_text'],   $search);

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

            //чпу
            $model->code = str_slug(empty($model->code) ? $model->title : $model->code);

            if(is_uploaded_file($model->image))
            {
                if($model->id)
                    self::find($model->id)->deleteImage();

                $upload = new Upload();
                $upload->fileName = $model->code;
                $upload->setPath(config('shop.news_path_file'));
                $upload->setFile($model->image);

                $model->image = $upload->save();
            }
        });

    }

    public function pathImage($firstSlash = false)
    {
        if(!empty($this->image))
            return ($firstSlash ? '/' : '') . config('shop.news_path_file') . $this->image;
        else
            false;
    }

    public function detailUrl(){
        return route('news_detail', ['code' => $this->code]);
    }

    public function deleteImage(){
        return File::delete($this->pathImage());
    }

}
