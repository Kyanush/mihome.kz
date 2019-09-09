<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Product;
use App\Models\Review;
use App\Requests\WriteReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends AdminController
{

    public function list(Request $request)
    {
        $search = $request->input('search');
        $product_id = $request->input('product_id');

        $reviews = Review::search($search)
            ->with(['product'])
            ->where(function ($query) use ($product_id){
                if($product_id)
                    $query->where('product_id', $product_id);
            })
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('per_page', 10));

        return $this->sendResponse($reviews);
    }

    public function delete($review_id)
    {
        return $this->sendResponse(Review::find($review_id)->delete() ? true : false);
    }

    public function save(WriteReviewRequest $request)
    {
        $data = $request->all();

        $review = Review::findOrNew($data["id"] ?? 0);
        $review->fill($data);
        $review->save();

        return $this->sendResponse(true);
    }


}