<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\SpecificPrice;
use App\Tools\Helpers;
use Illuminate\Http\Request;
use DB;

class SpecificPriceController extends AdminController
{
    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  SpecificPrice::with(['product'])->where(function ($query) use ($search){
                if(!empty($search))
                {
                    $query->whereHas('product', function($query) use ($search){
                        $query->filters(['name' => $search]);
                    });
                }
        })
        ->OrderBy('id', 'DESC')
        ->paginate($request->input('perPage', 5));

        foreach ($list as $key => $item)
        {
            $list[$key]->product->reduced_price  = Helpers::priceFormat($item->product->getReducedPrice());
            $list[$key]->product->path_photo     = $item->product->pathPhoto(true);
            $list[$key]->product->format_price   = Helpers::priceFormat($item->product->price);
        }

        return  $this->sendResponse($list);
    }

    public function delete($id)
    {
        return  $this->sendResponse(SpecificPrice::destroy($id) ? true : false);
    }

}
