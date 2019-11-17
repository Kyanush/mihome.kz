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

class CatalogController extends Controller
{

    public function c($category){

        //категория
        $category = Category::with(['children' => function($query){
            $query->orderBy('sort');
            $query->isActive();

        }])->where('url', $category)->firstOrFail();

        //seo
        $seo = Seo::catalog($category);

        return view('mobile.c', [
            'category'    => $category,
            'seo'         => $seo
        ]);

    }

    public function catalogCity($city, $category){
        return $this->catalogMain($city, $category);
    }

    public function catalog($category){
        return $this->catalogMain('almaty', $category);
    }

    public function catalogMain($city, $category_code){
        //категория
        $category = Category::isActive()->where('url', $category_code)->firstOrFail();

        $filters = Helpers::filtersProductsDecodeUrl($category_code);

        $filters['active'] = 1;

        $orderBy = Helpers::getSortedToFilter($filters);
        $column  = $orderBy['sorting_product']['column'];
        $order   = $orderBy['sorting_product']['order'];

        $priceMinMax = ServiceProduct::priceMinMax(['category' => $filters['category'], 'active' => 1]);
        $productsAttributesFilters = ServiceProduct::productsAttributesFilters($filters);




        $catalog = Product::productInfoWith()
            ->filters($filters)
            ->filtersAttributes($filters)
            ->OrderBy($column, $order)
            ->paginate(15);

        $productsHitViewed = Product::productInfoWith()
            ->filters($category_code ? ['category' => $category_code] : [])
            ->OrderBy('view_count', 'DESC')
            ->limit(10)
            ->get();


        //Вы смотрели
        $youWatchedProducts = ServiceYouWatchedProduct::listProducts(false, 7);

        //seo
        $seo = Seo::catalog($category);
        if(!$seo)
            return abort(404);


        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->parent_id, $category->name);


        return view(Helpers::isMobile() ? 'mobile.catalog' : 'site.catalog', [
            'catalog' => $catalog,
            'youWatchedProducts' => $youWatchedProducts,
            'productsHitViewed' => $productsHitViewed,
            'filters' => $filters,
            'category' => $category,
            'priceMinMax' => $priceMinMax,
            'productsAttributesFilters' => $productsAttributesFilters,
            'seo' => $seo,
            'breadcrumbs' => $breadcrumbs
        ]);
    }


}
