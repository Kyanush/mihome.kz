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

    public function __construct()
    {
        parent::__construct();
    }

    public function searchProducts(Request $request){
        $data = [];
        $search = $request->input('search');
        if($search)
        {

            $products = Product::filters(['name' => $search])
                            ->limit(10)
                            ->get();

            $data = $products->map(function ($item) {
                return  [
                    'product'    => $item,
                    'photo_path' => $item->pathPhoto(true),
                    'price'      => Helpers::priceFormat($item->getReducedPrice()),
                ];
            });
        }

        return $this->sendResponse($data);
    }

    public function list(Request $request)
    {
        $filters = $request->all();

        $sort = Helpers::sortConvert($filters['sort'] ?? false);
        $column = $sort['column'];
        $order  = $sort['order'];

        $main       = $request->input('main');
        $is_stock   = $request->input('is_stock');
        $arrival_id = $request->input('arrival_id');

        $list =  Product::with([
                'category',
                'specificPrice' => function($query){
                    $query->dateActive();
                },
                'stock',
                'status'
            ])
            ->where(function ($query) use ($main, $is_stock, $arrival_id){

                if($main)
                    $query->main();

                if($is_stock)
                    $query->whereHas('stock', function ($query) use ($arrival_id){
                        $query->where('price', '>',  0);

                        if($arrival_id)
                            $query->where('arrival_id', $arrival_id);

                    });

            })
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
            $list[$key]->balance = $item->balance($arrival_id);
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


            //Торговые предложения
            $groups = $request['groups'] ?? false;
            if($groups)
            {
                foreach ($groups as $group)
                {
                    $product_child = Product::find($group['id']);

                    if($group['price_type'] == 'null' or !$group['price_type'])
                        $group['price_type'] = '';

                    $product_child->fill($group);
                    $product_child->save();
                }
            }



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
                        'attributes',
                        'specificPrice',
                        'images',
                        'productAccessories',
                        'parent',
                        'children' => function($query){
                            $query->OrderBy('price', 'DESC');
                            $query->OrderBy('id', 'ASC');
                        }
                    ])->findOrFail($id);

        //фото товара
        $product->pathPhoto = $product->pathPhoto(true);

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
            'balance'             => $product->balance(),
            'detail_url'          => $product->detailUrlProduct(),
            'product'             => $product,
            'product_accessories' => $product_accessories,
            'images'              => $images,
            'specific_price'      => $product->specificPrice
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
              //  if(!$result['success'])
                   // return $this->sendResponse($result['message'] . ', ID товара:' . $product_id, 422);
            }

        //Статус
        if($action == 'active' and ($active == 0 or $active == 1))
        {
            $products =  Product::whereIn('id', $products_ids)->get();
            foreach ($products as $product)
            {
                $product->active = $active;
                $product->save();
            }
        }


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


