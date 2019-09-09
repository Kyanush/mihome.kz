<?php

namespace App\Http\Controllers\Sitemap;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\News;
use App\Models\Product;
use App\Services\ServiceCity;

class SitemapController extends Controller
{

    public function sitemap(){
        $cities     = ServiceCity::listActiveSort();
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.sitemap', compact(['cities', 'siteUrl']))->header('Content-Type', 'text/xml');
    }

    public function pages(){
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.pages', compact(['siteUrl']))->header('Content-Type', 'text/xml');
    }

    public function news(){
        $news = News::isActive()->OrderBy('created_at', 'DESC')->get();
        return response()->view('sitemap.news', compact(['news']))->header('Content-Type', 'text/xml');
    }

    public function city(){
        $city_code = \Route::currentRouteName();
        $city_code = str_replace("sitemap.", "", $city_code);

        $city = City::isActive()->where('code', $city_code)->firstOrFail();
        $products   = Product::with('categories')->filters(['active' => 1])->get();
        $categories = Category::isActive()->get();
        $siteUrl    = env('APP_URL');

        return response()->view('sitemap.city', [
            'city'       => $city,
            'products'   => $products,
            'categories' => $categories,
            'siteUrl'    => $siteUrl
        ])->header('Content-Type', 'text/xml');
    }

}