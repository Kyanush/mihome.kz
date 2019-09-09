<?php

namespace App\Models;

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
        'product_id',
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

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        //Событие после
        static::Created(function ($modal) {

            if($modal->email)
            {
                if(env('APP_TEST') == 0)
                {
                    $subject = env('APP_NAME') . ' - ' . 'Написать отзыв';
                    Mail::send('mails.write_review', ['data' => $modal, 'subject' => $subject], function ($m) use ($subject) {
                        $m->to(env('MAIL_ADMIN'))->subject($subject);
                    });
                }
            }

        });

        //до
        static::deleting(function($product) {
            $product->reviewLikes()->delete();
        });
    }

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['name', 'email', 'comment', 'plus', 'minus', 'product.name'],   $search);

        return $query;
    }

}