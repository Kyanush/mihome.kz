<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramBotUser extends Model
{

    protected $table = 'telegram_bot_users';
    protected $fillable = [
        'chat_id',
        'username',
        'first_name',
        'last_name'
	];

}