<?php
namespace App\Services;

use App\Models\ProductFeaturesWishlist;
use Auth;

class ServiceProductFeaturesWishlist
{


    public static function delete(int $product_id){
        return ProductFeaturesWishlist::isAuthUser()->where('product_id', $product_id)->delete();
    }

    public static function add(int $product_id)
    {
        $product = ProductFeaturesWishlist::findOrNew($product_id);
        $product->fill([
            'user_id'    => Auth::user()->id,
            'product_id' => $product_id

        ]);
        return $product->save() ? true : false;
    }

    public static function addOrDelete($product_id)
    {
        $compareProduct = ProductFeaturesWishlist::isAuthUser()->where('product_id', $product_id)->first();
        if($compareProduct){
            return self::delete($product_id);
        }else{
            return self::add($product_id);
        }
    }

    public static function count(){
        return ProductFeaturesWishlist::isAuthUser()->count();
    }

    public static function list(){
        return ProductFeaturesWishlist::with(['product' => function($query){
                                $query->with(['specificPrice' => function($query){
                                    $query->dateActive();
                                }]);
                            }])
                            ->isAuthUser()
                            ->get();
    }

}