<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Tools\Helpers;
use App\Tools\Seo;

class PageController extends Controller
{

    public function deliveryPayment(){
        $seo = Seo::pageSeo('delivery-payment');
        return view(Helpers::isMobile() ? 'mobile.page.delivery_payment' : 'site.page.delivery_payment', ['seo' => $seo]);
    }

    public function guaranty(){
        $seo = Seo::pageSeo('guaranty');
        return view(Helpers::isMobile() ? 'mobile.page.guaranty' : 'site.page.guaranty', ['seo' => $seo]);
    }

    public function contact(){
        $seo = Seo::pageSeo('contact');
        return view(Helpers::isMobile() ? 'mobile.page.contact' : 'site.page.contact', ['seo' => $seo]);
    }

    public function about(){
        $seo = Seo::pageSeo('about');
        return view(Helpers::isMobile() ? 'mobile.page.about' : 'site.page.about', ['seo' => $seo]);
    }

}
