<?php

namespace App\Http\Controllers\Telegram;
use App\Http\Controllers\Controller;
use App\Services\ServiceTelegram;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public $serviceTelegram;

    public function __construct()
    {
        $this->serviceTelegram = new ServiceTelegram();
    }

    public function telegram(Request $request){
        $this->serviceTelegram->get();
    }

}