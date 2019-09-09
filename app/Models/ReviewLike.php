<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tools\Helpers;

class ReviewLike extends Model
{
    protected $table = 'review_likes';
    protected $fillable = [
        'like',
        'visit_number',
        'review_id',
        'created_at',
        'updated_at'
    ];

    public function scopeSearchVisitNumber($query)
    {
        $query->where('visit_number', Helpers::visitNumber());
        return $query;
    }

    public function scopeLike($query){
        return $query->where('like', 1);
    }

    public function scopeDisLike($query){
        return $query->where('like', 0);
    }

}