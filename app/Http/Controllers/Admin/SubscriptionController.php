<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscriptionController extends AdminController
{

    public function subscriptions(Request $request)
    {

        $product_id = $request->input('product_id');

        $reviews = Subscribe::with(['product'])
            ->where(function ($query) use ($product_id){

                if($product_id)
                   $query->where('product_id', $product_id);

            })
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('per_page', 10));

        return $this->sendResponse($reviews);
    }

}
