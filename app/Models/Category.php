<?php

namespace App\Models;

use App\Services\ServiceCategory;
use App\Services\ServiceUploadUrl;
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
         'redirect_url',
         'image',
         'class',
         'sort',
         'type',
         'description',
         'seo_title',
         'seo_keywords',
         'seo_description',
         'active'
 	];

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
            $query->whereLike(['name'],   $search);

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
        static::Saving(function($category) {
            $category->url = str_slug(empty($category->url) ? $category->name : $category->url);

            if(is_uploaded_file($category->image))
            {
                if($category->id)
                    self::find($category->id)->deleteImage();

                $upload = new Upload();
                $upload->setWidth(100);
                $upload->setHeight(100);
                $upload->setPath(config('shop.categories_path_file'));
                $upload->setFile($category->image);

                $category->image = $upload->save();
            }
            //загрузка по ссылке
            elseif(ServiceUploadUrl::validUrlImage($category->image)){
                $serviceUploadUrl = new ServiceUploadUrl();

                if(!empty($category->id))
                    self::find($category->id)->deleteImage();

                $serviceUploadUrl->name = str_slug($category->name);
                $serviceUploadUrl->url = $category->image;
                $serviceUploadUrl->path_save = config('shop.categories_path_file');
                $filename = $serviceUploadUrl->copy();

                if($filename)
                {
                    $category->image = $filename;
                }
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

    public function catalogUrl($redirect_url = false)
    {
        if($redirect_url and $this->redirect_url)
        {
            return $this->redirect_url;
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
