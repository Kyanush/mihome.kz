<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AttributeGroup;
use App\Services\ServiceProductFeaturesCompare;
use App\Tools\Helpers;
use App\Tools\Seo;
use Redirect;

class ProductFeaturesCompareController extends Controller
{

    public function addAndDelete($product_id){
        return $this->sendResponse(
            ServiceProductFeaturesCompare::addOrDelete($product_id)
        );
    }

    public function count(){
        return $this->sendResponse(
            ServiceProductFeaturesCompare::count()
        );
    }

    public function compareProducts(){

        $attributeGroups = AttributeGroup::with('attributes')->OrderBy('sort')->get();
        $productFeaturesCompareList = ServiceProductFeaturesCompare::productFeaturesCompareList();
        $seo = Seo::pageSeo('compare-products');

        return view('site.compare_products', [
            'attributeGroups' => $attributeGroups,
            'productFeaturesCompareList' => $productFeaturesCompareList,
            'seo' => $seo
        ]);
    }

    public function compareProductDelete(int $product_id){
        if(ServiceProductFeaturesCompare::delete($product_id))
            return Redirect::back()->with('success', 'Ваш список сравнения изменен!');
        else
            return Redirect::back()->with('attention', 'Ошибка 404!');
    }

}
