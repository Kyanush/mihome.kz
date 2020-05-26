<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\ServiceSlider;
use App\Models\Product;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use App\Tools\Seo;
use Mail;

class MainController extends Controller
{

    public function main(){

        $products1 =Product::productInfoWith()
            ->whereIn('url', ['xiaomi-mi-note-10', 'xiaomi-mi-9t', 'xiaomi-mi-9t-pro', 'xiaomi-mi-10', 'xiaomi-mi-10-pro', 'xiaomi-mi-note-10'])
            ->get();

        $products2 = Product::productInfoWith()
                    ->whereIn('url', ['xiaomi-redmi-note-8', 'xiaomi-redmi-8-t', 'redmi-note-8-pro', 'xiaomi-redmi-8', 'xiaomi-redmi-8a', 'xiaomi-poco-x2-redmi-k30', 'xiaomi-redmi-note-9-pro'])
                    ->get();

        $products3 = Product::productInfoWith()
            ->whereIn('url', ['besprovodnoy-pylesos-xiaomi-roidmi-f8e', 'moyushchiy-robot-pylesos-xiaomi-roborock-s5-max', 'robot-pylesos-xiaomi-mijia-roborock-sweep-one-s50-white', 'besprovodnoy-pylesos-xiaomi-roidmi-nex'])
            ->get();

        $seo = Seo::main();

        $news = News::isActive()->limit(3)->OrderBy('created_at', 'DESC')->get();

        return view(Helpers::isMobile() ? 'mobile.main' : 'site.main',
            [
                'listSlidersHomePage'          => ServiceSlider::listSlidersHomePage(),
                'products1'                    => $products1,
                'products2'                    => $products2,
                'products3'                    => $products3,
                'seo'                          => $seo,
                'news'                         => $news
            ]);
    }

}
