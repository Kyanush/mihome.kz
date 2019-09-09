<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Requests\SetLikeRequest;
use App\Requests\WriteReviewRequest;
use App\Services\ServiceReview;

class ReviewController extends Controller
{

    public function setLike(SetLikeRequest $request)
    {
        $review_id = $request->input('review_id');
        $like = $request->input('like');

        ServiceReview::setLike($review_id, $like);

        $review = Review::withCount(['likes', 'disLikes'])->find($review_id);

        return $this->sendResponse([
            'likes_count'     =>  $review->likes_count,
            'dis_likes_count' => $review->dis_likes_count
        ]);
    }

    public function writeReview(WriteReviewRequest $request)
    {
        $review = Review::create($request->all());
        if($review){
            $review->delete();
            return $this->sendResponse(true);
        }
        return $this->sendResponse(false);
    }

}