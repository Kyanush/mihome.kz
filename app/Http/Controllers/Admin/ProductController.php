<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Models\AttributeSet;
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
        $products = Product::filters(['name' => $request->input('search')])
                        ->limit(5)
                        ->get();

        return $this->sendResponse($products);
    }

    public function list(Request $request)
    {
        $filters = $request->all();

        $sort = Helpers::sortConvert($filters['sort'] ?? false);
        $column = $sort['column'];
        $order  = $sort['order'];

        $list =  Product::with([
                'categories',
                'specificPrice' => function($query){
                    $query->dateActive();
                }
            ])
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

    public function AttributeSetsMoreInfo(){
        $list =  AttributeSet::with('attributes.values')->get();
        return  $this->sendResponse($list);
    }

    public function save(SaveProductRequest $req)
    {

        $request = $req->all();

        $reqProduct = $request['product'];
        $product = Product::findOrNew($reqProduct['id']);
        $product->fill($reqProduct);

        $old_attribute_set_id = $product->attribute_set_id;

        if($product->save())
        {
            //категория
            $product->categories()->sync($request['categories']);

            //Конкретная цена
            if(!empty($request['specific_price']['reduction']))
            {
                $SpecificPrice = SpecificPrice::firstOrNew(['product_id' => $product->id]);
                $SpecificPrice->fill($request['specific_price']);
                $SpecificPrice->save();
            }

            //Атрибуты
            ServiceProduct::productAttributesSave(
                $product->id,
                $request['attributes'],
                $old_attribute_set_id == $reqProduct['attribute_set_id'] ? false : true
            );

            //Картинки
            ServiceProduct::productImagesSave($request['product_images'] ?? [], $product->id);

            //Группа товаров
            ServiceProduct::productGroupSave($product->id, $product->group_id, $request['products_ids_group'] ?? []);

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
            'productAccessories'
        ])->findOrFail($id);

        //фото товара
        $product->pathPhoto = $product->pathPhoto(true);

        //категория
        $categories = $product->categories->pluck('id');


        //атрибуты
        $attributes = [];
        foreach ($product->attributes as $item)
            $attributes[$item->pivot->attribute_id][] = $item->pivot->value;


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
            'product'             => $product,
            'product_accessories' => $product_accessories,
            'images'              => $images,
            'attributes'          => $attributes,
            'categories'          => $categories,
            'specific_price'      => $product->specificPrice
        ]);
    }

    public function groupProducts($group_id)
    {
        $products = Product::where('group_id', $group_id)->get();

        $products = $products->map(function ($item) {
            return  [
                'id'         => $item->id,
                'name'       => $item->name,
                'sku'        => $item->sku,
                'price'      => $item->price,
                'active'     => $item->active
            ];
        });

        return  $this->sendResponse($products);
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
        $clone->clone_questions_answers   = $req['questions_answers'];
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
        $stock        = $request->input('stock');
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

        //Количество на складе
        if($action == 'stock' and $stock >= 0)
            Product::whereIn('id', $products_ids)->update(['stock' => $stock]);


        return $this->sendResponse(
            true
        );
    }

    public function productChangeQuicklySave(Request $request){

        $id     = $request->input('id');
        $stock  = intval($request->input('stock',  0));
        $price  = intval($request->input('price',  0));
        $active = intval($request->input('active', 0));

        $product = Product::find($id);
        $product->stock  = $stock;
        $product->price  = $price;
        $product->active = $active;

        return $this->sendResponse($product->save() ? true : false);
    }

}
