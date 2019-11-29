<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Models\AttributeProductValue;
use App\Services\ServiceProduct;
use Illuminate\Http\Request;

class ProductAttributeController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function save(Request $request){
        $data = $request->input('data');
        $product_id = $request->input('product_id');

        ServiceProduct::productAttributesSave($product_id, $data);

        return $this->sendResponse(true);
    }



    public function get($product_id){
        $product = Product::findOrFail($product_id);

        //атрибуты
        $attributes = $more = [];
        foreach ($product->attributes as $item)
        {
            if($item->pivot->attribute_id == 1)
            {
                $attributes[] = $item->pivot;
            }else{
                if(!isset($attributes[$item->pivot->attribute_id]))
                {
                    $attributes[$item->pivot->attribute_id] = [
                        'attribute_id' => $item->pivot->attribute_id,
                        'value'        => [ $item->pivot->value ]
                    ];
                }else{
                    $attributes[$item->pivot->attribute_id]['value'][] = $item->pivot->value;
                }
            }
        }
        $attributes = array_values($attributes);

        return $this->sendResponse($attributes);
    }
}
