<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use DB;
use App\Models\Status;

class Callback extends Model
{

    protected $table = 'callbacks';
    protected $fillable = [
        'phone',
        'type',
        'message',
        'email',
        'status_id',
        'comment'
	];

    public function scopeSearch($query, $search){
        if($search)
            $query->whereLike(['phone', 'type', 'message', 'email'],   $search);

        return $query;
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modal) {
            if(!$modal->status_id)
            {
                $modal->status_id = Status::whereUse(1)->defaultValue()->first()->id;
            }
        });

        //Событие после
        static::Created(function ($modal) {

            if(env('APP_TEST') == 0)
            {
                $subject = env('APP_NAME') . ' - ' . $modal->type;
                Mail::send('mails.callback', ['data' => $modal, 'subject' => $subject], function ($m) use ($subject) {
                    $m->to(env('MAIL_ADMIN'))->subject($subject);
                });
            }
        });

    }

}
