<?php

namespace App\Models;


use App\Services\ServiceCategory;
use App\Services\ServiceCity;
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
    	'group_id',
    	'attribute_set_id',
    	'name',
        'url',
    	'description',
        'description_mini',
        'photo',
    	'price',
    	'sku',
    	'stock',
        'seo_keywords',
        'seo_description',
    	'created_at',
    	'updated_at',
        'active',
        'youtube',
        'view_count'
	];

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }


    public function scopeFilters($query, $filters)
    {

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
        if(!empty($filters))
        {
            $attribute_codes = $value_codes = $values = [];

            foreach ($filters as $code => $value)
            {
                if(!empty($code) and !empty($value))
                {
                    $attribute_codes[] = (string)$code;
                    if(is_array($value)){
                        foreach ($value as $v)
                            if(trim($v))
                                $value_codes[] = (string)$v;
                }elseif(trim($value))
                        $value_codes[] = (string)$value;
                }
            }

            if(count($attribute_codes) > 0 and count($value_codes) > 0)
            {
                $attributes = Attribute::whereIn('code', $attribute_codes)->with(['values' => function($query) use ($value_codes){
                    $query->whereIn('code', $value_codes);
                }])
                    ->whereHas('values', function($query) use ($value_codes){
                        $query->whereIn('code', $value_codes);
                    })
                    ->get();

                foreach ($attributes as $attribute)
                {
                    foreach ($attribute->values as $value)
                    {
                        $values[] = (string)$value->value;
                    }
                }

                if($attribute_codes and $values)
                    $query->whereHas('attributes', function ($query) use ($attribute_codes, $values){
                        $query->whereIn('code',  $attribute_codes);
                        $query->whereIn('value', $values);
                    });
            }
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

            //группа товара
            if(empty($product->group_id))
                $product->group_id = ProductGroup::create()->id;

            //чпу
            $product->url = str_slug(empty($product->url) ? $product->name : $product->url);

            if(empty($product->id))
                $product_id = Helpers::tableNextId('products');

            //фото
            if(is_uploaded_file($product->photo))
            {
                if(!empty($product->id))
                    self::find($product->id)->deletePhoto();

                $upload = new Upload();
                $upload->fileName = str_slug($product->name);
                $upload->setWidth(300);
                $upload->setHeight(600);
                $upload->setPath($product->productFileFolder(false, $product_id ?? 0));
                $upload->setFile($product->photo);
                $product->photo = $upload->save();
            }

            if(empty($product->sku))
                $product->sku = $product->id ?? $product_id;

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
                    ->withPivot(['value']);
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

    //Отзывы
    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'product_id', 'id');
    }

    //Вопрос-ответ
    public function questionsAnswers()
    {
        return $this->hasMany('App\Models\QuestionAnswer', 'product_id', 'id');
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



    //Группа товаров
    public function group()
    {
        return $this->belongsTo('App\Models\ProductGroup');
    }
    public function groupProducts()
    {
        return $this->hasMany('App\Models\Product', 'group_id', 'group_id');
    }
    //Группа товаров

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
        return $this->hasOne('App\Models\Review', 'product_id', 'id')
            ->select(['product_id', DB::raw('TRUNCATE(avg(rating), 0) as avg_rating')])
            ->isActive()
            ->GroupBy('product_id');
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
        ->withCount(['reviews' => function($query){
            $query->isActive();
        }]);
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





    public function detailUrlProduct($city_code = ''){

        if(!$city_code)
        {
            $city = ServiceCity::getCurrentCity();
            $city_code = $city->code;
        }

        if($city_code == 'almaty')
            $city_code = '';

        if($city_code)
        {
            return route('productDetailCity',    ['product_url' => $this->url, 'city' => $city_code]);
        }else{
            return route('productDetailDefault', ['product_url' => $this->url]);
        }
    }

    public function detailUrlProductAdmin(){
        return '/admin/products/edit/' . $this->id;
    }

    public function pathPhoto($firstSlash = false)
    {
        if(!empty($this->photo))
            return $this->productFileFolder($firstSlash) . $this->photo;
        else
            false;
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