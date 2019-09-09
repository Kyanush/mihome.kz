<?php
namespace App\Services;

use App\Models\Review;
use App\Tools\Helpers;

class ServiceReview
{


    public static function setLike(int $review_id, int $like)
    {
        $review = Review::find($review_id);
        if($review)
        {
            $reviewLike = $review->reviewLikes()->searchVisitNumber()->first();

            if(!$reviewLike){
                $review->reviewLikes()->create([
                    'like' =>  $like,
                    'visit_number' => Helpers::visitNumber()
                ]);
            }else{
                if($reviewLike->like != $like)
                {
                    $reviewLike->like = $like;
                    $reviewLike->save();
                }
            }
            return true;
        }
        return false;
    }

}