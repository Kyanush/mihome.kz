<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Mail;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'role_id',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'active',
        'phone'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeSearch($query, $search)
    {
        if($search)
            $query->whereLike(['name', 'email', 'surname', 'phone'],   $search);

        return $query;
    }

    public function scopeRole($query, $role_id)
    {
        if(!empty($role_id))
            $query->whereIn('role_id', is_array($role_id) ? $role_id : [$role_id]);
        return $query;
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company', 'user_id', 'id');
    }

    public function hasRole($check)
    {
        if(is_array($check)){
            if(in_array($this->role->name, $check))
                return true;
        }elseif($this->role->name == $check)
            return true;

        return false;
    }

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

    protected static function boot()
    {
        parent::boot();

        //Событие до
        static::Creating(function ($modal) {

            $new_password = '';
            $modal->password = trim($modal->password);
            if(empty($modal->password))
            {
                $new_password = str_random(8);
                $modal->password = Hash::make($new_password);
            }

            if(env('APP_TEST') == 0)
            {
                $subject = env('APP_NAME') . ' - Благодарим за регистрацию';
                Mail::send('mails.register', ['user' => $modal, 'new_password' => $new_password, 'subject' => $subject,], function ($m) use ($modal, $subject) {
                    $m->to($modal->email)->subject($subject);
                });
            }

        });
    }

}
