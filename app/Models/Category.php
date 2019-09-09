<?php

namespace App\Models;

use App\Services\ServiceCity;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;
use App\Tools\Upload;

class Category extends Model
{


     protected $table = 'categories';
     protected $fillable = [
         'parent_id',
         'name',
         'url',
         'image',
         'class',
         'sort',
         'type',
         'description',
         'seo_keywords',
         'seo_description',
         'active'
 	];

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
            $query->whereLike(['name', 'url', 'description'],   $search);

        return $query;
    }

    public function scopeIsActive($query){
        $query->where("active", 1);
    }

    public function scopeIsNotActive($query){
        $query->where("active", 0);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function categoryFilterLinks()
    {
        return $this->hasMany('App\Models\CategoryFilterLink', 'category_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        //Событие до
        static::Saving(function($model) {
            $model->url = str_slug(empty($model->url) ? $model->name : $model->url);

            if(is_uploaded_file($model->image))
            {
                if($model->id)
                    self::find($model->id)->deleteImage();

                $upload = new Upload();
                $upload->setWidth(100);
                $upload->setHeight(100);
                $upload->setPath(config('shop.categories_path_file'));
                $upload->setFile($model->image);

                $model->image = $upload->save();
            }
        });

        static::deleting(function($obj) {
            $obj->deleteImage();
        });

    }

    public function pathImage($firstSlash = false)
    {
        if(!empty($this->image))
            return ($firstSlash ? '/' : '') . config('shop.categories_path_file') . $this->image;
        else
            false;
    }

    public function deleteImage(){
        return File::delete($this->pathImage());
    }

    public function catalogUrl($city_code = ''){

        if(!$city_code)
        {
            $city = ServiceCity::getCurrentCity();
            $city_code = $city->code;
        }

        if($city_code == 'almaty')
            $city_code = '';

        if($city_code){
            return route('catalogCity', ['category' => $this->url, 'city' => $city_code]);
        }else{
            return route('catalog', ['category' => $this->url]);
        }
    }

    public function typeValueDescription(){
        switch ($this->type) {
            case 'hit':
                return 'Hit';
                break;
            case 'new':
                return "New!";
                break;
            case 'skor':
                return "Скоро";
                break;
            default:
                return '';
        }
    }


}
