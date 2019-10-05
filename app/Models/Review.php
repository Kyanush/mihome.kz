<?php

namespace App\Models;

use App\Tools\Helpers;
use Illuminate\Database\Eloquent\Model;
use DB;
use Mail;


class Review extends Model
{

    protected $table = 'reviews';
    protected $fillable = [
        'name',
        'email',
        'comment',
        'plus',
        'minus',
        'rating',
        'active',
        'created_at',
        'updated_at'
    ];


    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

    public function isLike()
    {
        return $this->hasOne('App\Models\ReviewLike', 'review_id', 'id')
                    ->searchVisitNumber();
    }

    public function likes()
    {
        return $this->hasMany('App\Models\ReviewLike', 'review_id', 'id')->like();
    }

    public function disLikes()
    {
        return $this->hasMany('App\Models\ReviewLike', 'review_id', 'id')->disLike();
    }

    public function reviewLikes()
    {
        return $this->hasMany('App\Models\ReviewLike', 'review_id', 'id');
    }



    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'review_product', 'review_id', 'product_id');
    }

    protected static function boot()
    {
        parent::boot();

        //Событие после
        static::Created(function ($modal) {

            if($modal->email and env('APP_TEST') == 0 and !Helpers::isAdmin())
            {
                $subject = env('APP_NAME') . ' - ' . 'Написать отзыв';

                $emails = [ env('MAIL_ADMIN') ];

                Mail::send('mails.write_review', ['data' => $modal, 'subject' => $subject], function ($m) use ($subject, $emails) {
                    $m->to($emails)->subject($subject);
                });
            }

        });

        //до
        static::deleting(function($review) {
            $review->reviewLikes()->delete();
            $review->products()->detach();
        });

    }

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['name', 'email', 'comment', 'plus', 'minus', 'product.name'],   $search);

        return $query;
    }

}
