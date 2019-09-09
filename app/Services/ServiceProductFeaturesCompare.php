<?php
namespace App\Services;

use App\Models\ProductFeaturesCompare;
use App\Tools\Helpers;

class ServiceProductFeaturesCompare
{


    public static function add(int $product_id)
    {
        $product = ProductFeaturesCompare::findOrNew($product_id);
        $product->fill([
            'product_id'   => $product_id,
            'visit_number' => Helpers::visitNumber()
        ]);
        return $product->save() ? true : false;
    }

    public static function delete(int $product_id)
    {
        return ProductFeaturesCompare::searchVisitNumber()->where('product_id', $product_id)->delete();
    }

    public static function addOrDelete($product_id)
    {
        $compareProduct = ProductFeaturesCompare::searchVisitNumber()->where('product_id', $product_id)->first();
        if($compareProduct){
            return self::delete($product_id);
        }else{
            return self::add($product_id);
        }
    }

    public static function count(){
        return ProductFeaturesCompare::searchVisitNumber()->count();
    }

    public static function productFeaturesCompareList(){

        return ProductFeaturesCompare::with(['product' => function($query){
                $query->productInfoWith();
        }])
        ->searchVisitNumber()
        ->get();

    }
}