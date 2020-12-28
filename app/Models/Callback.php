<?php

namespace App\Models;

use App\Services\ServiceTelegram;
use Illuminate\Database\Eloquent\Model;
use Mail;
use DB;
use App\Models\Status;
use App\Models\Setting;

class Callback extends Model
{

    protected $table = 'callbacks';
    protected $fillable = [
        'name',
        'phone',
        'type',
        'message',
        'email',
        'status_id',
        'comment',
        'url'
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
                $modal->status_id = Status::callbacksStatusId()->defaultValue()->first()->id;
            }
        });

        //Событие после
        static::Created(function ($modal) {

            if(env('APP_TEST') == 0)
            {
                $emails = [];
                $settings = Setting::where('key', 'сallback_notification_email')->get();
                foreach ($settings as $setting)
                    $emails[] = $setting->value;

                if(count($emails) > 0)
                {
                    $subject = env('APP_NAME') . ' - ' . $modal->type;
                    Mail::send('mails.callback', ['data' => $modal, 'subject' => $subject], function ($m) use ($subject, $emails) {
                        $m->to($emails)->subject($subject);
                    });
                }

                $serviceTelegram = new ServiceTelegram();
                $serviceTelegram->sendCallback($modal->id);

            }
        });

    }

    public function adminDetailUrl(){
        return env('APP_URL') . '/admin/callback/' . $this->id;
    }

}
