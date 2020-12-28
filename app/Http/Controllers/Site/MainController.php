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

        $products1 =Product::filters(['category_id' => 284])
                            ->where('status_id', 10)
                            ->inRandomOrder()
                            ->limit(4)
                            ->get();

        $products2 =Product::filters(['category_id' => 282])
            ->where('status_id', 10)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $products3 =Product::filters(['category_id' => 286])
            ->where('status_id', 10)
            ->inRandomOrder()
            ->limit(4)
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
