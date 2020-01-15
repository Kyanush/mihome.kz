<?php

namespace App\Models;

use App\Services\ServiceCategory;
use App\Services\ServiceDB;
use App\Services\ServiceUploadUrl;
use Illuminate\Database\Eloquent\Model;
use File;
use App\Tools\Upload;
use DB;
use App\Tools\Helpers;
use Auth;
use Mail;

class Product extends Model
{


    protected $table = 'products';
    protected $fillable = [
        'parent_id',
    	'name',
        'sort',
        'url',
    	'description',
        'description_style_id',
        'photo',
    	'price',
    	'sku',
    	'stock',
        'status_id',
        'seo_title',
        'seo_keywords',
        'seo_description',
    	'created_at',
    	'updated_at',
        'active',
        'youtube',
        'view_count',
        'reviews_rating_avg',
        'reviews_count',
	];

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

    public function scopeMain($query){
        return $query->where('parent_id', 0);
    }

    public function scopeNotMain($query){
        return $query->where('parent_id', '>', 0);
    }

    public function descriptionStyle()
    {
        return $this->belongsTo('App\Models\Status', 'description_style_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function scopeFilters($query, $filters)
    {

        if(isset($filters['main']))
            $query->main();

        if(isset($filters['created_at_start']))
            $query->whereDate('created_at', '>=', $filters['created_at_start']);
        if(isset($filters['created_at_end']))
            $query->whereDate('created_at', '<=', $filters['created_at_end']);


        if(isset($filters['name']))
            $query->whereLike('name',   $filters['name']);


        if(isset($filters['price_start']))
            $query->where('price', '>=', $filters['price_start']);
        if(isset($filters['price_end']))
            $query->where('price', '<=', $filters['price_end']);

        if(isset($filters['sku']))
            $query->whereLike('sku',   $filters['sku']);

        if(isset($filters['stock_end']))
            $query->where('stock', '>=', $filters['stock_end']);
        if(isset($filters['stock_start']))
            $query->where('stock', '<=', $filters['stock_start']);

        if(isset($filters['url']))
            $query->whereLike('url',   $filters['url']);

        if(isset($filters['active']))
            $query->where('active', $filters['active']);

        if(!empty($filters['category']))
        {


            $category = Category::where('url', $filters['category'])->first();
            if($category)
            {
                $categories_ids = ServiceCategory::categoryChildIds($category->id);

                $query->whereHas('categories', function($query) use ($categories_ids){
                    $query->whereIn('category_id', $categories_ids);
                });
            }
        }

        return $query;
    }

    public function scopeFiltersAttributes($query, $filters){

            $product_attribute_count = $product_ids = [];

            if(count($filters) > 0)
                foreach ($filters as $filter_code => $filter_value)
                {

                    if(empty($filter_code) or empty($filter_value))
                        continue;

                    $attribute = Attribute::where('code', $filter_code)->first();
                    if($attribute)
                    {
                       $value = $attribute->values()->where('code', $filter_value)->first()->value ?? false;
                       if($value)
                       {
                           $attributeProductValue = AttributeProductValue::where('attribute_id', $attribute->id)->where('value', $value)->get();
                           foreach ($attributeProductValue as $item)
                           {
                               $product_attribute_count[ $item->product_id ][] = $item->product_id;
                           }
                       }
                    }
                }

            $max = 0;
            foreach ($product_attribute_count as $key => $item)
            {
                if(count($item) > $max)
                    $max = count($item);
            }

            foreach ($product_attribute_count as $key => $item)
            {
                if(count($item) == $max)
                {
                    $product_ids[$key] = $key;
                }
            }

            if(count($product_ids) > 0)
            {
                $query->whereIn('id', $product_ids);
            }

        return $query;
    }




	protected static function boot()
    {
        parent::boot();

        //до
        static::deleting(function($product) {
        });

        //после
        static::Deleted(function($product) {
        });

        //Событие до
        static::Updating(function($product) {


            if(env('APP_TEST') == 0 and $product->stock > 0)
            {
                    $old_stock = self::find($product->id)->stock;

                    if ($product->stock != $old_stock and empty($old_stock))
                    {
                        $subscribe = $product->subscribe;
                        if($subscribe)
                        {
                            foreach ($subscribe as $item)
                            {
                                $subject = env('APP_NAME') . ' - ' . 'Товар "' . $product->name . '" в наличии';
                                Mail::send('mails.is_stock_product', ['product' => $product, 'subject' => $subject], function ($m) use ($item, $subject) {
                                    $m->to($item->email)->subject($subject);
                                });
                            }
                        }
                    }
            }


        });

        //Событие до
        static::Saving(function($product) {

            if($product->active != 0 and $product->active != 1)
                $product->active = 1;

            if(!is_numeric($product->stock))
                $product->stock = 1;

            if(!$product->status_id)
                $product->status_id = Status::where('where_use', 'products_status_id')->defaultValue()->first()->id;

            //чпу
            $product->url = str_slug(empty($product->url) ? $product->name : $product->url);

            if(empty($product->id))
            {
                $product_id = ServiceDB::tableNextId('products');

                $path_folder = public_path(config('shop.products_path_file') . $product_id) . '/';
                if(!File::isDirectory($path_folder))
                    File::makeDirectory($path_folder, 0777, true, true);

            }else{
                $product_id = $product->id;
            }



            //фото
            if(is_uploaded_file($product->photo))
            {
                if(!empty($product->id))
                    self::find($product->id)->deletePhoto();

                $upload = new Upload();
                $upload->fileName = str_slug($product->name);
                //$upload->setWidth(300);
                //$upload->setHeight(600);
                $upload->setPath(config('shop.products_path_file') . $product_id . '/');
                $upload->setFile($product->photo);
                $fileName = $upload->save();
                if($fileName)
                {
                    $product->photo = $fileName;
                }
            }
            //загрузка по ссылке
            elseif(ServiceUploadUrl::validUrlImage($product->photo))
            {
                $serviceUploadUrl = new ServiceUploadUrl();
                if(!empty($product->id))
                    self::find($product->id)->deletePhoto();

                $serviceUploadUrl->name = str_slug($product->name);
                $serviceUploadUrl->url = $product->photo;
                $serviceUploadUrl->path_save = public_path(config('shop.products_path_file') . $product_id) . '/';
                $filename = $serviceUploadUrl->copy();
                if($filename)
                {
                    $product->photo = $filename;
                }
            }

            if($product->parent_id == 0)
            {
                 $product->children()->update(['stock' => $product->stock]);
            }

        });
    }


    //категория
	public function categories()
	{
        return $this->belongsToMany('App\Models\Category', 'category_product', 'product_id', 'category_id');
    }

    //атрибуты
	public function attributes()
	{
		return $this->belongsToMany('App\Models\Attribute', 'attribute_product_value', 'product_id', 'attribute_id')
                    ->withPivot(['name', 'value']);
	}

    public function attributeProductValue()
    {
        return $this->hasMany('App\Models\AttributeProductValue');
    }

    //Картинка
	public function images()
	{
		return $this->hasMany('App\Models\ProductImage')->orderBy('order', 'ASC');
	}

	//аксессуары
    public function productAccessories()
    {
        return $this->belongsToMany('App\Models\Product', 'product_accessories', 'product_id', 'accessory_product_id');
    }

    //аксессуары
    public function productAccessoriesBack()
    {
        return $this->belongsToMany('App\Models\Product', 'product_accessories', 'accessory_product_id', 'product_id');
    }

    //Отзывы
    public function reviews()
    {
        return $this->belongsToMany('App\Models\Review', 'review_product', 'product_id', 'review_id');
    }

    //подписка
    public function subscribe()
    {
        return $this->hasMany('App\Models\Subscribe', 'product_id', 'id');
    }

    //Скидки
    public function specificPrice()
    {
        return $this->hasOne('App\Models\SpecificPrice', 'product_id', 'id');
    }

    //товары в корзине
    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem', 'product_id', 'id');
    }

    //Сравнение товаров
    public function featuresCompare(){
        return $this->hasMany('App\Models\ProductFeaturesCompare', 'product_id', 'id');
    }

    //Мои закладки
    public function featuresWishlist(){
        return $this->hasMany('App\Models\ProductFeaturesWishlist', 'product_id', 'id');
    }

    //Вы смотрели продукты
    public function youWatchedProducts(){
        return $this->hasMany('App\Models\YouWatchedProduct', 'product_id', 'id');
    }



    public function avgRating()
    {
         return $this->belongsToMany('App\Models\Review', 'review_product', 'product_id', 'review_id')
            ->select([DB::raw('t_review_product.product_id'), DB::raw('TRUNCATE(avg(rating), 0) as avg_rating')])
            ->isActive()
            ->GroupBy(DB::raw('t_review_product.product_id'));
    }

    public function oneProductFeaturesCompare()
    {
        return $this->hasOne('App\Models\ProductFeaturesCompare', 'product_id', 'id')
                    ->where('visit_number', Helpers::visitNumber());
    }

    public function oneProductFeaturesWishlist()
    {
        return $this->hasOne('App\Models\ProductFeaturesWishlist', 'product_id', 'id')
                    ->where('user_id', Auth::check() ? Auth::user()->id : 0);
    }

    public function inCart(){
        return $this->hasOne('App\Models\CartItem', 'product_id', 'id')
                    ->whereHas('cart', function ($query){
                         $query->currentUser();
                    });
    }

    public function scopeProductInfoWith($query){
        return
        $query->with([
            'specificPrice' => function($query){
                $query->dateActive();
            },
            'attributes',
            'categories',
            'avgRating',
            'oneProductFeaturesCompare',
            'oneProductFeaturesWishlist',
            'inCart'
        ])
        ->isActive()

            /*
        ->withCount(['reviews' => function($query){
            $query->isActive();
        }])
        */
        ;
    }



    /**** Скидки   ***/
    public function getReducedPrice()
    {
        $price = $this->price;
        if($this->specificPrice)
        {
            switch ($this->specificPrice->discount_type)
            {
                case 'percent':
                    $price = $price - $this->specificPrice->reduction / 100 * $price;
                break;
                case 'sum':
                    $price = $price - $this->specificPrice->reduction;
                break;
            }
        }
        return $price;
    }
    public function getDiscountTypeinfo(){
        if($this->specificPrice)
        {
            switch ($this->specificPrice->discount_type) {
                case 'percent':
                    return '-' . $this->specificPrice->reduction . '%';
                    break;
                case 'sum':
                    return '-' . $this->specificPrice->reduction . '₸';
                    break;
                default:
                    return '';
            }
        }
        return '';
    }

    public function detailUrlProduct(){
        return route('productDetail', ['product_url' => $this->url]);
    }

    public function detailUrlProductAdmin(){
        return env('APP_URL') . '/admin/product/' . $this->id;
    }

    public function pathPhoto($firstSlash = false)
    {
        if($this->photo == 'zashchitnoye-steklo.png')
        {
            return '/site/images/zashchitnoye-steklo.png';
        }else{
            if($this->photo)
                return $this->productFileFolder($firstSlash) . $this->photo;
            else
                return false;
        }
    }

    public function productFileFolder($firstSlash = false, $product_id = 0)
    {
        return ($firstSlash ? '/' : '') . config('shop.products_path_file') . (empty($product_id) ? $this->id : $product_id) . '/';
    }

    public function deletePhoto()
    {
        if($this->pathPhoto())
           return File::delete($this->pathPhoto());
        else
            return false;
    }

}
