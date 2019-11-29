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


    public function productDetail($product_url){

        if(isset($_GET['dddyyyydffff']))
        {
            $products = Product::WhereIn('id', [1284, 1285, 1286, 1287, 1288, 1289, 1290, 1291])->get();
            foreach ($products as $product)
            {

                $product->attributes()->detach();

                $t_attribute_product_value = DB::select('SELECT * FROM `t_attribute_product_value` WHERE `product_id` = 1283');
                foreach ($t_attribute_product_value as $value) {

                    if ($value->value)
                        $product->attributes()->attach([$value->attribute_id => ['value' => $value->value]]);

                }
            }
        }


        $product = Product::productInfoWith()
                            ->with(['images' => function($query){
                                    $query->OrderBy('order', 'ASC');
                                }
                            ])
                            ->where('url', $product_url)
                            ->firstOrFail();

        if(Helpers::isMobile()){
            $view = $_GET['view'] ?? false;
            if($view == 'reviews')
                $reviews = $product->reviews()->with('isLike')->withCount(['likes', 'disLikes'])->isActive()->get();
            else
                $reviews = $product->reviews()->with('isLike')->withCount(['likes', 'disLikes'])->isActive()->paginate(2);
        }else{
            $reviews = $product->reviews()->with('isLike')->withCount(['likes', 'disLikes'])->isActive()->paginate(3);
        }


        $ratings_groups = $product->reviews()
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();

        //Похожие товары
        if($product->parent_id){
            $group_products = Product::where('parent_id', $product->parent_id)->productInfoWith()->OrderBy('price')->get();
        }else{
            $group_products = $product->children()->productInfoWith()->OrderBy('price')->get();
        }

        //С этим товаром покупаю
        $products_interested = $product->productAccessories()->productInfoWith()->get();
        if($products_interested->isEmpty())
            $products_interested = $product->productAccessoriesBack()->productInfoWith()->get();

        //Вы смотрели
        ServiceYouWatchedProduct::youWatchedProduct($product->id);
        $youWatchedProducts = ServiceYouWatchedProduct::listProducts($product->id, 10);



        //Кол-во просмотров
        if(!Helpers::isAdmin())
            $product->increment('view_count');

        //категория
        if($product->parent_id)
        {
            $category = Category::find($product->parent->categories[0]->id);
        }else{
            $category = Category::find($product->categories[0]->id);
        }

        //Хлебная крошка
        $breadcrumbs = ServiceCategory::breadcrumbCategories($category->id, $product->name);

        //seo
        $seo = Seo::productDetail($product, $category);

        if($product->parent_id)
        {
            $product_parent = $product->parent;
            $product->description = $product_parent->description;
            $product->description_full_screen = $product_parent->description_full_screen;

            foreach ($product_parent->attributes as $k1 => $attribute1)
            {
                $add = true;
                foreach ($product->attributes as $k2 => $attribute2)
                {
                    if($attribute1->id == $attribute2->id)
                    {
                        $add = false;
                        break;
                    }
                }
                if($add)
                {
                    $product->attributes->push($attribute1);
                }
            }
        }


        return view(Helpers::isMobile() ? 'mobile.product.index' : 'site.product_detail', [
            'product'             => $product,
            'reviews'             => $reviews,
            'ratings_groups'      => $ratings_groups,
            'group_products'      => $group_products,
            'products_interested' => $products_interested,
            'youWatchedProducts'  => $youWatchedProducts,
            'category'            => $category,
            'seo'                 => $seo,
            'breadcrumbs'         => $breadcrumbs,
        ]);
    }

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
