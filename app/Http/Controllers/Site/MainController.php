<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\ServiceSlider;
use App\Models\Product;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use App\Tools\Seo;

class MainController extends Controller
{

    public function main(){




        $productsDiscount = Product::productInfoWith()
                ->whereHas('specificPrice', function ($query){
                    $query->dateActive();
                })
                ->withCount('reviews')
                ->limit(10)
                ->where('stock', '>', 0)
                //->OrderBy('id', 'DESC')
                ->inRandomOrder()
                ->get();


        $elektrosamokaty =Product::productInfoWith()
            ->filters(['category' => 'elektrosamokaty-xiaomi'])
            ->limit(10)
            ->where('stock', '>', 0)
            ->get();



        $pylesosy = Product::productInfoWith()
                    ->filters(['category' => 'pylesosy-xiaomi'])
                    ->limit(10)
                    ->where('stock', '>', 0)
                    ->get();



        $seo = Seo::main();

        $news = News::isActive()->limit(3)->OrderBy('created_at', 'DESC')->get();

        return view(Helpers::isMobile() ? 'mobile.main' : 'site.main',
            [
                'listSlidersHomePage'          => ServiceSlider::listSlidersHomePage(),
                'productsDiscount'             => $productsDiscount,
                'elektrosamokaty'              => $elektrosamokaty,
                'pylesosy'                     => $pylesosy,
                'seo'                          => $seo,
                'news'                         => $news
            ]);
    }

}
