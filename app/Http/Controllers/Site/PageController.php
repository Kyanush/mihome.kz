<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Tools\Seo;

class PageController extends Controller
{

    public function deliveryPayment(){
        $seo = Seo::pageSeo('delivery-payment');
        return view('site.page.delivery_payment', ['seo' => $seo]);
    }

    public function guaranty(){
        $seo = Seo::pageSeo('guaranty');
        return view('site.page.guaranty', ['seo' => $seo]);
    }

    public function contact(){
        $seo = Seo::pageSeo('contact');
        return view('site.page.contact', ['seo' => $seo]);
    }

    public function about(){
        $seo = Seo::pageSeo('about');
        return view('site.page.about', ['seo' => $seo]);
    }

}
