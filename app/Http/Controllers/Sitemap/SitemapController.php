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
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.sitemap', compact(['siteUrl']))->header('Content-Type', 'text/xml');
    }

    public function pages(){
        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.pages', compact(['siteUrl']))->header('Content-Type', 'text/xml');
    }

    public function news(){
        $news = News::isActive()->OrderBy('created_at', 'DESC')->get();
        return response()->view('sitemap.news', compact(['news']))->header('Content-Type', 'text/xml');
    }

    public function products(){

        $products   = Product::with('categories')->filters(['active' => 1])->get();
        $categories = Category::isActive()->get();

        $siteUrl    = env('APP_URL');
        return response()->view('sitemap.products', compact(['city', 'products', 'categories', 'siteUrl']))->header('Content-Type', 'text/xml');
    }

}