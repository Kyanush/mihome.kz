<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ServiceCategory;
use App\Services\ServiceProduct;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use App\Tools\Seo;
use function Couchbase\defaultDecoder;

class CatalogController extends Controller
{


    public function productDetail($product_url){

        $product = Product::productInfoWith()
            ->with(['images' => function($query){
                $query->OrderBy('order', 'ASC');
            }
            ])
            ->where('url_full', $product_url)
            ->firstOrFail();

        $reviews = $ratings_groups = false;


        //Похожие товары
        if($product->parent_id){
            $group_products = Product::with('status')->where('parent_id', $product->parent_id)->productInfoWith()->OrderBy('price')->get();
        }else{
            $group_products = $product->children()->with('status')->productInfoWith()->OrderBy('price')->get();
        }

        //С этим товаром покупаю
        $products_interested = $product->productAccessories()->productInfoWith()->limit(10)->get();
        if($products_interested->isEmpty())
            $products_interested = $product->productAccessoriesBack()->productInfoWith()->limit(10)->get();


        //Кол-во просмотров
        if(!Helpers::isAdmin())
            $product->increment('view_count');

        //категория
        if($product->parent_id)
        {
            $category = Category::find($product->parent->category->id);
        }else{
            $category = Category::find($product->category->id);
        }

        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->id, $product->name);

        //seo
        $seo = Seo::productDetail($product, $category);

        if($product->parent_id)
        {
            $product_parent = $product->parent;

            $product->description = $product_parent->description;
            $product->attributes  = $product_parent->attributes;

            $product->description_short  = $product_parent->description_short;
            $product->description_schema = $product_parent->description_schema;
            $product->reviews_rating_avg = $product_parent->reviews_rating_avg;
            $product->reviews_count      = $product_parent->reviews_count;
            $product->specifications     = $product_parent->specifications;

            if(count($product->images) == 0)
                $product->images = $product_parent->images;
        }


        return view(Helpers::isMobile() ? 'mobile.product.index' : 'site.product_detail', [
            'product'             => $product,
            'reviews'             => $reviews,
            'ratings_groups'      => $ratings_groups,
            'group_products'      => $group_products,
            'products_interested' => $products_interested,
            'category'            => $category,
            'seo'                 => $seo,
            'breadcrumbs'         => $breadcrumbs,
        ]);
    }

    public function catalog($code = ''){

        $url = Helpers::parseCurrentUrl();
        $current_url       = $url['url'];
        $current_url_array = $url['arr'];


        //категория
        $category = Category::isActive()->where('url_full', $current_url)->first();
        if(!$category){
            //товар детально
            return $this->productDetail($current_url);
        }else
            $category = Category::isActive()->where('url_full', $current_url)->firstOrFail();


        $catalog = Product::isActive()
                          ->filters(['category_id' => $category->id])
                          ->productInfoWith()
                          ->orderByRaw('FIELD(status_id, 10, 11, 12), sort desc')
                          ->paginate(15);

        //seo
        $seo = Seo::catalog($category);
        if(!$seo)
            return abort(404);

        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->parent_id, $category->name_short ? $category->name_short : $category->name);

        return view(Helpers::isMobile() ? 'mobile.catalog' : 'site.catalog', [
            'catalog'                   => $catalog,
            'category'                  => $category,
            'seo'                       => $seo,
            'breadcrumbs'               => $breadcrumbs
        ]);
    }


}
