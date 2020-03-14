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


    public function catalog($code){

        if($code == 'xiaomi-mi-note-10')
            return redirect()->route('productDetail', ['product_url' => 'xiaomi-mi-note-10']);


        //категория
        $category = Category::isActive()->where('url', $code)->firstOrFail();

        $filters = Helpers::filtersProductsDecodeUrl($code);

        $filters['active'] = 1;
        $filters['main']   = 1;

        $orderBy = Helpers::getSortedToFilter($filters);
        $column  = $orderBy['sorting_product']['column'];
        $order   = $orderBy['sorting_product']['order'];



        $priceMinMax = ServiceProduct::priceMinMax(['category' => $filters['category'], 'active' => 1, 'main' => 1]);
        $productsAttributesFilters = ServiceProduct::productsAttributesFilters($filters);

        $catalog = Product::productInfoWith()
            ->filters($filters)
            ->filtersAttributes($filters)
            ->OrderBy($column, $order)
            ->paginate(15);

        //seo
        $seo = Seo::catalog($category);
        if(!$seo)
            return abort(404);

        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->parent_id, $category->name);

        return view(Helpers::isMobile() ? 'mobile.catalog' : 'site.catalog', [
            'catalog'                   => $catalog,
            'filters'                   => $filters,
            'category'                  => $category,
            'priceMinMax'               => $priceMinMax,
            'productsAttributesFilters' => $productsAttributesFilters,
            'seo'                       => $seo,
            'breadcrumbs'               => $breadcrumbs
        ]);
    }


}
