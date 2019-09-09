<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ServiceProductFeaturesWishlist;
use App\Tools\Helpers;
use App\Tools\Seo;
use Redirect;

class ProductFeaturesWishlistController extends Controller
{

    public function addAndDelete($product_id){
        return $this->sendResponse(
            ServiceProductFeaturesWishlist::addOrDelete($product_id)
        );
    }

    public function count(){
        return $this->sendResponse(
            ServiceProductFeaturesWishlist::count()
        );
    }

    public function wishlist(){
        $seo = Seo::pageSeo('wishlist');
        return view('site.wishlist', [
            'wishlist' => ServiceProductFeaturesWishlist::list(),
            'seo' => $seo
        ]);
    }

    public function delete(int $product_id){
        if(ServiceProductFeaturesWishlist::delete($product_id))
            return Redirect::back()->with('success', 'Закладки успешно обновлены!');
        else
            return Redirect::back()->with('attention', 'Ошибка 404!');
    }

}
