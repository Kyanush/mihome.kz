<?php
namespace App\Services;


use App\Models\YouWatchedProduct;
use App\Tools\Helpers;

class ServiceYouWatchedProduct
{

    public static function youWatchedProduct(int $product_id)
    {
        if(!YouWatchedProduct::where('product_id', $product_id)->searchVisitNumber()->first())
        {
            YouWatchedProduct::create([
                'product_id'   => $product_id,
                'visit_number' => Helpers::visitNumber()
            ]);
            return true;
        }
        return false;
    }

    public static function listProducts($product_id = false)
    {
        $products = [];
        $youWatchedProducts = YouWatchedProduct::searchVisitNumber()->with(['product' => function($query) use ($product_id){
                                    $query->productInfoWith();

                                    if($product_id)
                                       $query->whereNotIn('id', is_array($product_id) ? $product_id : [$product_id]);

                              }])->OrderBy('id', 'DESC')->get();

        foreach ($youWatchedProducts as $item)
        {
            if(isset($item->product))
                $products[] = $item->product;
        }

        return $products;
    }

}