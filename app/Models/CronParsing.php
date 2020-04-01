<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CronParsing extends Model
{
     //public $timestamps = false;
     protected $table = 'cron_parsing';
     protected $fillable = [
         'url',
         'site',
         'parsing'
 	];
}