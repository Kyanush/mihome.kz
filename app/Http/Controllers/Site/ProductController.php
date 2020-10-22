<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ServiceCategory;
use App\Services\ServiceYouWatchedProduct;
use App\Tools\Helpers;
use App\Tools\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ProductController extends Controller
{



    public function productSearch(Request $request){

        $products = Product::filters(['name' => $request->input('searchText'), 'active' => 1])->limit(10)->get();
        $data = $products->map(function ($item) {
            return [
                'id'      => $item->id,
                'name'    => $item->name,
                'url'     => $item->detailUrlProduct(),
                'photo'   => $item->pathPhoto(true),
                'price'   => Helpers::priceFormat($item->getReducedPrice()),
            ];
        });

        return  $this->sendResponse($data);
    }

    public function productImages($product_id){
        $product = Product::with('images')->findOrFail($product_id);

        $images = $product->images->map(function ($image) {
            return [ $image->imagePath(true) ];
        });

        return  $this->sendResponse([
            'images'  => $images,
            'youtube' => $product->youtube,
            'photo'   => $product->pathPhoto(true)
        ]);
    }

    public function setRating(Request $request){

        $product_id = $request->input('product_id');
        $reviews_rating_avg = $request->input('reviews_rating_avg');
        $reviews_count = $request->input('reviews_count');

        $product = Product::findOrFail($product_id);
        $product->reviews_rating_avg = $reviews_rating_avg;
        $product->reviews_count = $reviews_count;
        $product->save();

        return  $this->sendResponse($request->all());

    }

    public function getProduct($product_id){
        $product = Product::findOrFail($product_id);
        return  $this->sendResponse([
            'product'          => $product,
            'detailUrlProduct' => $product->detailUrlProduct(),
            'pathPhoto'        => $product->pathPhoto(true),
            'price'            => Helpers::priceFormat($product->getReducedPrice()),
            'attributes'       => $product->attributes
        ]);
    }

}
