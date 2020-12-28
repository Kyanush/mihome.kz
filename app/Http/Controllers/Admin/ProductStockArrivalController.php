<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\ProductStockArrival;

class ProductStockArrivalController extends AdminController
{

    public function list(){
        $prodcutStock = ProductStockArrival::all();
        return  $this->sendResponse($prodcutStock);
    }

    public function save(Request $request)
    {
        $data = $request->all();

        foreach ($data as $item)
        {
            if($item['name'])
            {
                $productStock = ProductStockArrival::findOrNew($item['id'] ?? 0);
                $productStock->fill($item);
                $productStock->save();
            }
        }

        return  $this->sendResponse(true);
    }

}