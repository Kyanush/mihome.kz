<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Models\SpecificPrice;
use App\Requests\CloneProductRequest;
use App\Requests\SaveProductRequest;
use App\Services\ServiceProduct;
use App\Services\ServiceProductClone;
use App\Tools\Helpers;
use Illuminate\Http\Request;
use DB;

class ProductController extends AdminController
{



    public function searchProducts(Request $request){
        $search = $request->input('search');
        if($search)
        {
            $products = Product::filters(['name' => $request->input('search')])
                            ->limit(10)
                            ->get();

            foreach ($products as $key => $product)
            {
                $products[$key]->reduced_price        = $product->getReducedPrice();
                $products[$key]->reduced_price_format = Helpers::priceFormat($product->getReducedPrice());
                $products[$key]->photo_path           = $product->pathPhoto(true);
            }

        }

        return $this->sendResponse($products ?? []);
    }

    public function list(Request $request)
    {
        $filters = $request->all();

        $sort = Helpers::sortConvert($filters['sort'] ?? 'id-DESC');
        $column = $sort['column'];
        $order  = $sort['order'];

        $list =  Product::with([
                'category',
                'specificPrice' => function($query){
                    $query->dateActive();
                }
            ])
            ->main()
            ->filters($filters)
            ->filtersAttributes($filters)
            ->OrderBy($column, $order)
            ->paginate($request->input('perPage', 10));

        foreach ($list as $key => $item)
        {
            if($item->specificPrice)
            {
                $list[$key]->price_discount = Helpers::priceFormat($item->getReducedPrice());
            }

            $list[$key]->path_photo = $item->pathPhoto(true);
            $list[$key]->format_price = Helpers::priceFormat($item->price);

            $list[$key]->detail_url_product = $item->detailUrlProduct();
        }

        return  $this->sendResponse($list);
    }

    public function save(SaveProductRequest $req)
    {

        $request = $req->all();

        $reqProduct = $request['product'];
        $product = Product::findOrNew($reqProduct['id']);
        $product->fill($reqProduct);


        if($product->save())
        {

            //Конкретная цена
            if(!empty($request['specific_price']['reduction']))
            {
                $SpecificPrice = SpecificPrice::firstOrNew(['product_id' => $product->id]);
                $SpecificPrice->fill($request['specific_price']);
                $SpecificPrice->save();
            }else{
                $product->specificPrice()->delete();
            }

            //Картинки
            ServiceProduct::productImagesSave($request['product_images'] ?? [], $product->id);


            //С этим товаром покупают
            if(isset($request['accessories_product_ids']))
                $product->productAccessories()->sync($request['accessories_product_ids']);
        }
        return  $this->sendResponse($product->id);
    }

    public function view($id)
    {
        $product = Product::with([
            'categories',
            'attributes',
            'specificPrice',
            'images',
            'productAccessories',
            'parent',
            'children' => function($query){
                $query->OrderBy('price');
            }
        ])->findOrFail($id);

        //фото товара
        $product->pathPhoto = $product->pathPhoto(true);

        $children = $product->children->map(function ($item) {
            return  [
                'id'             => $item->id,
                'name'           => $item->name,
                'sku'            => $item->sku,
                'price'          => Helpers::priceFormat($item->getReducedPrice()),
                'old_price'      => Helpers::priceFormat($item->price),
                'active'         => $item->active
            ];
        });

        //картинки
        $images = $product->images->map(function ($item) {
            return  [
                'id'         => $item->id,
                'is_delete'  => 0,
                'image_view' => $item->imagePath(true),
                'value'      => ''
            ];
        });


        //С этим товаром покупают
        $product_accessories = $product->productAccessories->map(function ($item) {
            return  [
                'id'         => $item->id,
                'name'       => $item->name,
                'active'     => $item->active
            ];
        });


        return $this->sendResponse([
            'discount_price'      => [
                 'sum'    => $product->getReducedPrice(),
                 'format' => Helpers::priceFormat($product->getReducedPrice()),
                 'discount_type_info' => $product->getDiscountTypeinfo()
            ],
            'detail_url'          => $product->detailUrlProduct(),
            'product'             => $product,
            'product_accessories' => $product_accessories,
            'images'              => $images,
            'specific_price'      => $product->specificPrice,
            'children'            => $children
        ]);
    }


    public function delete($product_id)
    {
        $data = ServiceProduct::productDelete($product_id);
        if($data['success'])
        {
            return $this->sendResponse(true);
        }else{
            return $this->sendResponse($data['message'], 422);
        }
    }

    public function cloneProduct(CloneProductRequest $req)
    {
        $req = $req->input('clone_product');

        $clone = new ServiceProductClone($req['product_id']);
        $clone->data = ['sku' => $req['sku'], 'name' => $req['name']];
        $clone->clone_group               = $req['group'];
        $clone->clone_photo               = $req['photo'];
        $clone->clone_attributes          = $req['attributes'];
        $clone->clone_specific_price      = $req['specific_price'];
        $clone->clone_product_images      = $req['product_images'];
        $clone->clone_reviews             = $req['reviews'];
        $clone->clone_product_accessories = $req['product_accessories'];
        $result = $clone->clone();

        return  $this->sendResponse($result);
    }

    public function priceMinMax(Request $request)
    {
        return $this->sendResponse(
            ServiceProduct::priceMinMax($request->all())
        );
    }

    public function productsAttributesFilters(Request $request){
        return $this->sendResponse(
            ServiceProduct::productsAttributesFilters($request->all(), false)
        );
    }

    public function productsSelectedEdit(Request $request){

        $products_ids = $request->input('products_ids');
        $active       = $request->input('active');
        $action       = $request->input('action');
        $all          = $request->input('all');
        $filter       = $request->input('filter');

        if($all)
            $products_ids =  Product::filters($filter)->pluck('id')->toArray();

        //Удалить
        if($action == 'delete')
            foreach ($products_ids as $product_id)
            {
                $result = ServiceProduct::productDelete($product_id);
                if(!$result['success'])
                    return $this->sendResponse($result['message'] . ', ID товара:' . $product_id, 422);
            }

        //Статус
        if($action == 'active' and ($active == 0 or $active == 1))
            Product::whereIn('id', $products_ids)->update(['active' => $active]);

        return $this->sendResponse(
            true
        );
    }

    public function productChangeQuicklySave(Request $request){

        $id     = $request->input('id');
        $price  = intval($request->input('price',  0));
        $active = intval($request->input('active', 0));

        $product = Product::find($id);
        $product->price  = $price;
        $product->active = $active;

        return $this->sendResponse($product->save() ? true : false);
    }


}
