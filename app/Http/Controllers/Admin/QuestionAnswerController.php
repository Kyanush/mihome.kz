<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Models\QuestionAnswer;
use App\Requests\WriteQuestionRequest;
use Illuminate\Http\Request;

class QuestionAnswerController extends AdminController
{

    public function list(Request $request)
    {
        $product_id = $request->input('product_id', 0);

        $reviews = QuestionAnswer::search($request->input('search'))
            ->with(['product'])
            ->where(function ($query) use ($product_id){
                if($product_id > 0)
                    $query->where('product_id', $product_id);
            })
            ->OrderBy('id', 'DESC')
            ->paginate($request->input('per_page', 10));

        return $this->sendResponse($reviews);
    }

    public function delete($review_id)
    {
        return $this->sendResponse(QuestionAnswer::find($review_id)->delete() ? true : false);
    }

    public function save(WriteQuestionRequest $request)
    {
        $data = $request->all();

        $review = QuestionAnswer::findOrNew($data["id"] ?? 0);
        $review->fill($data);
        $review->save();

        return $this->sendResponse(true);
    }


}